<?php
/*
 * This file is part of the Sonata project.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Sonata\UserBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class ChangePasswordFOSUser1Controller
 *
 * This class is inspired from the FOS Change Password Controller
 *
 * @package Sonata\UserBundle\Controller
 *
 * @author  Hugo Briand <briand@ekino.com>
 */
class ChangePasswordFOSUser1Controller extends Controller
{
    public function changePasswordAction()
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $form              = $this->container->get('fos_user.change_password.form');
        $request           = $this->container->get('request');
        $presentedPassword = $request->get('fos_user_change_password_form')['current_password'];
        $newFirstPassword  = $request->get('fos_user_change_password_form')['new']['first'];
        $newSecondPassword = $request->get('fos_user_change_password_form')['new']['second'];

        if($presentedPassword !== NULL && $presentedPassword !== '') {
            $encoderFactory = $this->container->get('security.encoder_factory');

            if($encoderFactory->getEncoder($user)->isPasswordValid($user->getPassword(), $presentedPassword, $user->getSalt())) {

                if($newFirstPassword === $newSecondPassword) {
                    $formHandler = $this->container->get('fos_user.change_password.form.handler');
                    $process     = $formHandler->process($user);

                    if ($process) {
                        $this->setFlash('fos_user_success', 'change_password.flash.success');

                        return new RedirectResponse($this->getRedirectionUrl($user, 'sonata_admin_dashboard'));
                    }
                } else {
                    $this->setFlash('error', 'Los campos "Nueva Contraseña" y "Repita la nueva contraseña" no coinciden, por favor vuela a ingresarlas.');
                }
            } else {
                $this->setFlash('error', 'La contraseña actual, que ha sido ingresada no es válida, por favor intente nuevamente.');
            }
        }

        return $this->container->get('templating')->renderResponse(
            'SonataUserBundle:ChangePassword:changePassword.html.'.$this->container->getParameter('fos_user.template.engine'),
            array('admin_pool' => $this->container->get('sonata.admin.pool'),'form' => $form->createView())
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getRedirectionUrl(UserInterface $user, $route_name = NULL)
    {
        if ($route_name === NULL) {
            $route_name = 'sonata_user_profile_show';
        }

        return $this->container->get('router')->generate($route_name);
    }

    /**
     * @param string $action
     * @param string $value
     */
    protected function setFlash($action, $value)
    {
        $this->container->get('session')->getFlashBag()->set($action, $value);
    }
}
