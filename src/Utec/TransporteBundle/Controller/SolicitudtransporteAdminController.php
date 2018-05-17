<?php

namespace Utec\TransporteBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Utec\TransporteBundle\Entity\Paquetetransporte;

class SolicitudtransporteAdminController extends CRUDController
{

    //para crear una nueva actividad
    /**
     * Create action.
     *
     * @return Response
     *
     * @throws AccessDeniedException If access is not granted
     */
    public function createAction()
    {
        $request = $this->getRequest();
        // the key used to lookup the template
        $templateKey = 'create';

        $this->admin->checkAccess('create');

        $class = new \ReflectionClass($this->admin->hasActiveSubClass() ? $this->admin->getActiveSubClass() : $this->admin->getClass());

        if ($class->isAbstract()) {
            return $this->render(
                'SonataAdminBundle:CRUD:select_subclass.html.twig',
                array(
                    'base_template' => $this->getBaseTemplate(),
                    'admin' => $this->admin,
                    'action' => 'create',
                ),
                null,
                $request
            );
        }

        $object = $this->admin->getNewInstance();

        $preResponse = $this->preCreate($request, $object);
        if ($preResponse !== null) {
            return $preResponse;
        }

        $this->admin->setSubject($object);

        /** @var $form \Symfony\Component\Form\Form */
        $form = $this->admin->getForm();
        $form->setData($object);
        $form->handleRequest($request);
        $em = $this ->getDoctrine()->getManager();
        $user=$this->getUser();
        $now = new \DateTime();

        if ($form->isSubmitted()) {
                $em->getConnection()->beginTransaction();
                try {
                    $object->setHorafechareg($now);
                    $object->setIdusuarioreg($user);
                    $object->setActiva(true);
                    $object = $this->admin->create($object);

                    $arrayMonitoreo=$request->get('datosMonitoreo');
                    foreach ($arrayMonitoreo['add'] as $key => $row) {

                        $origen=$em ->getRepository('UtecTransporteBundle:Ctlmunicipio')->findOneById(4);
                        $solicitudDetalle = new Paquetetransporte();

                        //$origen=$em ->getRepository('UtecTransporteBundle:Ctlmunicipio')->findOneById( $row ['origen']);
                        $destino=$em ->getRepository('UtecTransporteBundle:Ctlmunicipio')->findOneById( 5);
                        $vehiculo=$em ->getRepository('UtecTransporteBundle:CtlVehiculo')->findOneById(6);
                        $solicitudDetalle->setApagar($row['apagar']);
                        $solicitudDetalle->setDescripcionPaquete($row['paquete']);
                        $solicitudDetalle->setClaveRastreo($row['clave']);
                        $solicitudDetalle->setLugardestino($row['dirdestino']);
                        $solicitudDetalle->setDirecciondestino($row['dirdestino']);
                        $solicitudDetalle->setEntregado(false);
                        $solicitudDetalle->setClaveRastreo($row['clave']);
                        $solicitudDetalle->setIdmunicipiodestino($destino);
                        $solicitudDetalle->setIdmunicipioorigen($origen);
                        $solicitudDetalle->setIdvehiculo($vehiculo);
                        $solicitudDetalle->setIdsolicitud($object);
                        $this->admin->create($solicitudDetalle);
                    }//fin foreach
                    $em->getConnection()->commit();
                    $this->addFlash(
                        'sonata_flash_success',
                        $this->trans(
                            'flash_create_success',
                            array('%name%' => $this->escapeHtml($this->admin->toString($object))),
                            'SonataAdminBundle'
                        )
                    );

                    // redirect to edit mode
                    return $this->redirectTo($object);
                } catch(Exception $e){
                    $em->getConnection()->rollback();
                    $this->addFlash('sonata_flash_error', $e);
                }

            // show an error message if the form failed validation
            if (!$isFormValid) {
                if (!$this->isXmlHttpRequest()) {
                    $this->addFlash(
                        'sonata_flash_error',
                        $this->trans(
                            'flash_create_error',
                            array('%name%' => $this->escapeHtml($this->admin->toString($object))),
                            'SonataAdminBundle'
                        )
                    );
                }
            } elseif ($this->isPreviewRequested()) {
                //pick the preview template if the form was valid and preview was requested
                $templateKey = 'preview';
               $this->admin->getShow();
            }
        }//fin if form is isSubmitted

        $formView = $form->createView();
        // set the theme for the current Admin Form
        //$this->setFormTheme($formView, $this->admin->getFormTheme());



        return $this->render($this->admin->getTemplate($templateKey), array(
            'action' => 'create',
            'form' => $formView,
            'object' => $object,

        ), null);
    }

    public function reporteAction()
{
  return $this->render('UtecTransporteBundle::CRUD/reporte.html.twig');
}


}
