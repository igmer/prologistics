<?php

namespace Utec\TransporteBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class SolicitudtransporteAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper

            ->add('idcliente')
            ->add('horafechareg')
            ->add('activa')

        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper


            /*->add('fechahorarecoleccion',null,
                array(
                  'label'=>'Fecha de Recoleccion ',

                  'widget'   => 'single_text',
                  'format'   => 'dd/MM/yyyy',
                  'attr'     => array(
                      'class'                => 'bootstrap-datepicker',
                      'data-mask'            => '99/99/9999',
                      'placeholder'          => 'dd/mm/aaaa',
                      'data-date-start-date' => '0',
                      'data-date-end-date' => '0d',
                      'data-date-start-view' => '0'
                  )
              )
              )*/


            ->add('idcliente')
            ->add('activa')
            ->add('catalogoDetalle')

            ->add('_action', null, array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                ),
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
        ->with('General',array('class' => 'col-lg-6 col-md-6 col-sm-12 col-xs-12'))

        /*->add('fechahorarecoleccion',null,
            array(
              'label'=>'Fecha de Recoleccion ',

              'widget'   => 'single_text',
              'format'   => 'dd/MM/yyyy',
              'attr'     => array(
                  'class'                => 'bootstrap-datepicker',
                  'data-mask'            => '99/99/9999',
                  'placeholder'          => 'dd/mm/aaaa',
                  'data-date-start-date' => '0',
                  'data-date-end-date' => '0d',
                  'data-date-start-view' => '0'
              )
          )
          )*/
          ->add('idcliente',null, array(
              'label'=> 'Cliente',
              'attr'=>array(
                  'required'=>true
              )
          ))
          ->add('activa')
          ->end()
          ->with('Asignar',array('class' => 'col-lg-6 col-md-6 col-sm-12 col-xs-12'))


        ->end()
        ->with('Paquetes')
               ->add('catalogoDetalle','sonata_type_collection',array('label' =>'Elemento'),
                                                                array('edit' => 'inline', 'inline' => 'table'))
           ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('lugarrecoleccion')
            ->add('fechahorarecoleccion')
            ->add('horafechareg')
            ->add('activa')
            ->add('claverastreo')
        ;
    }
    public function getTemplate($name) {
        switch ($name) {
            case 'create':
            return 'UtecTransporteBundle::CRUD/solicitud/createsel.html.twig';
            break;
            case 'show':
            return 'UtecTransporteBundle::CRUD/solicitud/show.html.twig';
            break;
            default:
            return parent::getTemplate($name);
            break;
        }
    }
    public function preUpdate($detalleMonitoreo) {
        $user = $this->getConfigurationPool()->getContainer()->get('security.context')->getToken()->getUser();
        $detalleMonitoreo->setIdUsuarioReg($user);
        $detalleMonitoreo->setHorafechareg(new \DateTime());
//
      foreach ($detalleMonitoreo->getCatalogoDetalle() as $detalle) {
       $detalle->setIdsolicitud($detalleMonitoreo);
//           $detalle->setIdUsuarioReg($user);
//            $detalle->setFechaHoraReg(new \DateTime());
//
        }

}
protected function configureRoutes(RouteCollection $collection) {

        $collection->add('reporte');
    }
}
