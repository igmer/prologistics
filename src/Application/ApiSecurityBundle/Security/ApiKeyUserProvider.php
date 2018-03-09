<?php
// src/Application/ApiSecurityBundle/Security/ApiKeyUserProvider.php
namespace Application\ApiSecurityBundle\Security;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Application\Sonata\UserBundle\Entity\User;

class ApiKeyUserProvider implements UserProviderInterface
{
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public function getUsernameForApiKey($apiKey)
    {
        $em = $this->container->get('doctrine')->getManager();
        $ApiOpenSessions = $em->getRepository('ApplicationApiSecurityBundle:ApiOpenSessions')->findOneByUuid($apiKey);

        $username = $ApiOpenSessions ? $ApiOpenSessions->getIdUsuario()->getUsername() : null;

        return $username;
    }

    public function loadUserByUsername($username)
    {
        $em   = $this->container->get('doctrine')->getManager();
		$user = $em->getRepository("ApplicationSonataUserBundle:User")->findOneByUsername($username);

		return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        // this is used for storing authentication in the session
        // but in this example, the token is sent in each request,
        // so authentication can be stateless. Throwing this exception
        // is proper to make things stateless
        throw new UnsupportedUserException();
    }

    public function supportsClass($class)
    {
        return User::class === $class;
    }
}
