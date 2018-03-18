<?php

namespace Utec\TransporteBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class SolicitudtransporteAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper

            ->add('lugarrecoleccion')
            ->add('fechahorarecoleccion')
            ->add('horafechareg')
            ->add('activa')
            ->add('claverastreo')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper

            ->add('lugarrecoleccion')
            ->add('fechahorarecoleccion',null,
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
              )

              ->add('idmotorista', null, array(
                  'label'=>' Motorista'
              ))
            ->add('activa')
            ->add('claverastreo')
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
        ->add('lugarrecoleccion')
        ->add('fechahorarecoleccion',null,
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
          )

          ->add('idmotorista', null, array(
              'label'=>' Motorista'
          ))
          ->add('activa')
          ->end()
          ->with('Asignar',array('class' => 'col-lg-6 col-md-6 col-sm-12 col-xs-12'))
          ->add('idprioridad', null, array(
              'label'=>'Prioridad'
          ))
          ->add('idvehiculo',null, array(
              'label'=>'Marca del vehiculo que solicita'
          ))

        ->add('claverastreo')
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
    public function prePersist($paq) {
      $user = $this->getConfigurationPool()->getContainer()->get('security.context')->getToken()->getUser();
      $paq->setIdUsuarioReg($user);
      $paq->setHoraFechaReg(new \DateTime());

      foreach ($paq->getCatalogoDetalle() as $catalogoDetalle) {
            $catalogoDetalle->setIdsolicitud($paq);
            //$catalogoDetalle->setIdUsuarioReg($user);
            //$catalogoDetalle->setFechaHoraReg(new \DateTime());

        }
  }
}
