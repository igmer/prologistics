<?php

namespace Utec\TransporteBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class PaquetetransporteAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {

    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('descripcionPaquete')
            ->add('idmunicipioorigen', null, array(
                'label'=>'Municipio de Origen'
            ))
            ->add('direcciondestino', null, array(
                'label'=>' Direccion Referencia'
                     ))

            //->add('claveRastreo')
            ->add('lugardestino', null, array(
                'label'=>'Direccion Destino'
            ))
            ->add('idmunicipiodestino', null, array(
                'label'=>'Municipio Destino'
            ))
            ->add('idvehiculo', null, array(
                'label'=>'Vehiculo Asignado'
            ))

            ->add('entregado')
            ->add('apagar', null, array(
                'label'=>'Total a pagar'
            ))
            ->add('claveRastreo', null, array(
                'label'=>'Clave de Rastreo'
            ))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('direcciondestino')
            ->add('entregado')
            ->add('apagar')
        ;
    }
}
