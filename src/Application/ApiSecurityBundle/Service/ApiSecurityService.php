<?php
namespace Application\ApiSecurityBundle\Service;

use Doctrine\DBAL\Connection;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Application\ApiSecurityBundle\Entity\ApiOpenSessions;

class ApiSecurityService {
	private $container;

	public function __construct($container = null) {
        $this->container = $container;
    }

    public function signIn($username, $password) {
        if( $username === NULL || $username === '' ) {
            throw new MissingOptionsException('El nombre de usuario no ha sido proporcionado');
        }

		if( $password === NULL || $password === '') {
            throw new MissingOptionsException('La contraseña no ha sido proporcionada');
        }

		$request  = $this->container->get('request');
		$data     = array('estado' => false, 'mensaje' => '', 'token' => null);
		$em       = $this->container->get('doctrine')->getManager();
		$userRepo = $em->getRepository("ApplicationSonataUserBundle:User");

		$user = $userRepo->findOneByUsername($username);

		if (!$user) {
		    $data['mensaje'] = "El nombre de usuario '$username' no ha sido encontrado";
		} else {
			$userChecker    = $this->container->get('security.user_checker.api');
			$encoderFactory = $this->container->get('security.encoder_factory');

			try {
				$userChecker->checkPreAuth($user);
				if( !$encoderFactory->getEncoder($user)->isPasswordValid($user->getPassword(), $password, $user->getSalt()) ) {
					$data['mensaje'] = 'Credenciales inválidas.';
				}
				$userChecker->checkPostAuth($user);
			} catch (\Exception $e) {
				$data['mensaje'] = 'Credenciales inválidas, Detalle: '.$e->getMessage;
			}

			if( $data['mensaje'] === '' ) {
				if( !$this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY') ) {
					$this->login($user);
				}

				$uuid = $this->createGuid();
				$now  = new \DateTime();

				$ApiOpenSessions = new ApiOpenSessions();
				$ApiOpenSessions->setUuid($uuid);
				$ApiOpenSessions->setIdUsuario($user);
				$ApiOpenSessions->setUuidCreatedAt($now);
				$ApiOpenSessions->setUuidLastUsed($now);

				$em->persist($ApiOpenSessions);
				$em->flush();

				$data['token']  = $uuid;
				$data['estado'] = true;
			}
		}

		return $data;
    }

	public function signOut($uuid) {
		try {
			$valid = $this->isValidGuid($uuid);
		} catch (\Exception $e) {
			throw new AccessDeniedHttpException('La GUID proporcionada no es válida, Detalle: '.$e->getMessage());
		}

		$data = array('estado' => true, 'mensaje' => 'Sesión de Usuario Finalizada con Éxito');

		if( $valid ) {
			$user = $this->getUserByGuid($uuid);

			if($user) {
				try {
					$this->invalidateUser($uuid);
				} catch (\Exception $e) {
					throw new $e;
				}
			}
		}

		return $data;
	}

	public function isValidGuid($uuid) {
		try {
			$user = $this->getUserByGuid($uuid);
		} catch (\Exception $e) {
			throw new AccessDeniedHttpException($e->getMessage());
		}

		$valid = false;

		if($user) {
			$idleTime = $this->container->hasParameter('api_idle_time') ? $this->container->getParameter('api_idle_time') : 0;
			$now      = new \DateTime();
			$em       = $this->container->get('doctrine')->getManager();
			$ApiOpenSessions = $em->getRepository('ApplicationApiSecurityBundle:ApiOpenSessions')->findOneByUuid($uuid);
			$lastUsed = $ApiOpenSessions->getUuidLastUsed();
			$interval = $now->getTimestamp() - $lastUsed->getTimestamp();

			if( $interval >= 0 && $interval < $idleTime ) {
				$valid = true;

				if( !$this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY') ) {
					$this->login($user);
				}

				$ApiOpenSessions->setUuidLastUsed($now);

				$em->persist($ApiOpenSessions);
				$em->flush();
			} else {
				try {
					$invalidateData = $this->invalidateUser($uuid);
				} catch (\Exception $e) {
					throw new $e;
				}
			}
		}

		return $valid;
	}

	public function isGranted($uuid, $role) {
		$securityChecker = $this->container->get('security.context');
		$role            = strtoupper($role);
		$isGranted       = false;

		try {
			$valid = $this->isValidGuid($uuid);
		} catch (\Exception $e) {
			throw new AccessDeniedHttpException('La GUID proporcionada no es válida, Detalle: '.$e->getMessage());
		}

		if( $valid ) {
			$user = $this->getUserByGuid($uuid);

			if($user) {
				if( $securityChecker->isGranted($role) || $user->hasRole($role) ) {
					$isGranted = true;
				}
			}
		}

		return $isGranted;
	}

	private function getUserByGuid($uuid) {
		if( $uuid === NULL || $uuid === '') {
            throw new MissingOptionsException('El parámetro GUID no ha sido proporcionado');
        }

		$em   = $this->container->get('doctrine')->getManager();
		$ApiOpenSessions = $em->getRepository('ApplicationApiSecurityBundle:ApiOpenSessions')->findOneByUuid($uuid);

		$user = $ApiOpenSessions ? $ApiOpenSessions->getIdUsuario() : null;

		return $user;
	}

	private function invalidateUser($uuid) {
		$securityContext = $this->container->get('security.context');
		$session = $this->container->get('session');
		$em      = $this->container->get('doctrine')->getManager();

		$ApiOpenSessions = $em->getRepository('ApplicationApiSecurityBundle:ApiOpenSessions')->findOneByUuid($uuid);

		if( $ApiOpenSessions ) {
			try {
				$em->remove($ApiOpenSessions);
				$em->flush();

				$securityContext->setToken(null);
				$session->invalidate();
			} catch (\Exception $e) {
				throw $e;
			}
		}

		return true;
	}

	private function createGuid() {
	    if (function_exists('com_create_guid') === true)
	        return trim(com_create_guid(), '{}');

	    $data = openssl_random_pseudo_bytes(16);
	    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
	    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
	    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
	}

	private function login($user)
	{
		if ( !( $user instanceof UserInterface ) ) {
			$request = $this->container->get('request');

			// Here, "main" is the name of the firewall in your security.yml
	        $token = new UsernamePasswordToken($user, $user->getPassword(), "api", $user->getRoles());

	        // For older versions of Symfony, use security.context here
	        $this->container->get("security.token_storage")->setToken($token);

	        // Fire the login event
	        // Logging the user in above the way we do it doesn't do this automatically
	        $event = new InteractiveLoginEvent($request, $token);
	        $this->container->get("event_dispatcher")->dispatch("security.interactive_login", $event);
		}
	}
}
