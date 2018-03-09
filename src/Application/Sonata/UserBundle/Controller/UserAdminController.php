<?php
// src/Application/Sonata/UserBundle/Controller/UserAdminController.php

namespace Application\Sonata\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL as DBAL;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;


class UserAdminController extends CRUDController {
    /**
     * execute a batch locked
     *
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     *
     * @param \Sonata\AdminBundle\Datagrid\ProxyQueryInterface $query
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function batchActionLocked(ProxyQueryInterface $query) {
        if (false === $this->admin->isGranted('EDIT')) {
            throw new AccessDeniedException();
        }

        $modelManager = $this->admin->getModelManager();
        try {
            $this->batchLocked(true, $query);
            $this->addFlash('sonata_flash_success', $this->admin->trans('flash_batch_locked_success',array(), 'messages'));
        } catch ( ModelManagerException $e ) {
            $this->addFlash('sonata_flash_error', $this->admin->trans('flash_batch_locked_error',array(), 'messages'));
        }

        return new RedirectResponse($this->admin->generateUrl('list', array('filter' => $this->admin->getFilterParameters())));
    }

    /**
     * execute a batch unlocked
     *
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     *
     * @param \Sonata\AdminBundle\Datagrid\ProxyQueryInterface $query
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function batchActionUnlocked(ProxyQueryInterface $query) {
        if (false === $this->admin->isGranted('EDIT')) {
            throw new AccessDeniedException();
        }

        $modelManager = $this->admin->getModelManager();
        try {
            $this->batchLocked(false, $query);
            $this->addFlash('sonata_flash_success', $this->admin->trans('flash_batch_unlocked_success',array(), 'messages'));
        } catch ( ModelManagerException $e ) {
            $this->addFlash('sonata_flash_error', $this->admin->trans('flash_batch_unlocked_error', array(), 'messages'));
        }

        return new RedirectResponse($this->admin->generateUrl('list', array('filter' => $this->admin->getFilterParameters())));
    }

    private function batchLocked($status, ProxyQueryInterface $queryProxy) {
        $queryProxy->select('DISTINCT '.$queryProxy->getRootAlias());

        try {
            $entityManager = $this->getDoctrine()->getManager();

            $i = 0;
            foreach ($queryProxy->getQuery()->iterate() as $pos => $object) {
                if($object[0]->getUsername() !== 'admin') {
                    $object[0]->setLocked($status);
                }

                if ((++$i % 20) == 0) {
                    $entityManager->flush();
                    $entityManager->clear();
                }
            }

            $entityManager->flush();
            $entityManager->clear();
        } catch (\PDOException $e) {
            throw new ModelManagerException('', 0, $e);
        } catch (DBALException $e) {
            throw new ModelManagerException('', 0, $e);
        }
    }
}
