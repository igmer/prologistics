<?php
namespace Application\CoreBundle\EventListener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class TimeOutListener {
    protected $session;
    protected $securityContext;
    protected $router;
    protected $maxIdleTime;

    public function __construct(SessionInterface $session, AuthorizationCheckerInterface $authorizationChecker, TokenStorage $tokenStorage, RouterInterface $router, $maxIdleTime = 0) {
        $this->session         = $session;
        $this->authorizationChecker = $authorizationChecker;
        $this->tokenStorage = $tokenStorage;
        $this->router          = $router;
        $this->maxIdleTime     = $maxIdleTime;
    }

    public function onKernelRequest(GetResponseEvent $event) {
        if (HttpKernelInterface::MASTER_REQUEST != $event->getRequestType()) {
            return;
        }

        $request = $event->getRequest();
        $_route  = $request->attributes->get('_route');

        if($this->tokenStorage->getToken() !== null &&  $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            if(!$this->session->has('lastUsed')) {
                $this->session->set('lastUsed', $this->session->getMetadataBag()->getLastUsed());
            }

            if($_route !== "timeInfo") {
                $this->session->set('lastUsed', $this->session->getMetadataBag()->getLastUsed());
            }

            if ($this->maxIdleTime > 0) {
                $this->session->start();
                $lapse = time() - $this->session->get('lastUsed');

                if ($lapse > $this->maxIdleTime) {
                    $redirect = $this->router->generate($_route);
                    $this->tokenStorage->setToken(null);
                    $this->session->invalidate();
                    $this->session->getFlashBag()->add('session_expired_warning', 'La sesion ha sido cerrada por inactividad.');
                    $event->setResponse(new RedirectResponse($redirect));
                }
            }
        } else {
            if($_route === "timeInfo") {
                if(!$this->session->getFlashBag()->has('session_expired_warning')) {
                    $this->session->getFlashBag()->add('session_expired_warning', 'La sesion ha sido cerrada por inactividad.');
                }
            }
        }
    }
}
