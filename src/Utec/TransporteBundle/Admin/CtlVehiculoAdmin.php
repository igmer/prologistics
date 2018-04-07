<?php

namespace Utec\TransporteBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CtlVehiculoAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper

            ->add('modelo')
            ->add('marca')
            ->add('placa')
            ->add('pesomax')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('marca')
            ->add('modelo')
            ->add('idtipovehiculo','text', array(
                'label'=>'Tipo Vehiculo'
            ))
            
            ->add('placa')
            ->add('pesomax',null, array(
                'label'=>'Peso Max. (Kg)'
            ))

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
            ->with('Modelo y Marca',array('class' => 'col-lg-4 col-md-4 col-sm-12 col-xs-12'))
                ->add('modelo')
                ->add('marca')
            ->end()
            ->with('N° Placa y Peso Maximo',array('class' => 'col-lg-4 col-md-4 col-sm-12 col-xs-12'))
                ->add('placa')
                ->add('pesomax', null, array(
                    'label'=>'Peso Maximo (Kg)'
                ))
            ->end()
            ->with('Estado y Tipo Vehiculo',array('class' => 'col-lg-4 col-md-4 col-sm-12 col-xs-12'))
            ->add('idEstado', null, array(
                'label'=>'Estado'
            ))

            ->add('idtipovehiculo', null, array(
                'label'=>'Tipo de Vehiculo'
            ))
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper

            ->add('modelo')
            ->add('marca')
            ->add('placa')
            ->add('pesomax')
            ->add('idEstado')
            ->add('idtipovehiculo')
        ;
    }
}
