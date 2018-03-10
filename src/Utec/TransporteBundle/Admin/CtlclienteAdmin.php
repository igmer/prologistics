<?php

namespace Utec\TransporteBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CtlclienteAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper

            ->add('nombrerepresentante')
            ->add('nombreempresa')
            ->add('direccion')
            ->add('telefono')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper

            ->add('nombrerepresentante')
            ->add('nombreempresa')
            ->add('direccion')
            ->add('telefono')
            ->add('_action', null, array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),

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
            ->add('nombreempresa', null,array(
                'label'=>'Empresa que Representa'
            ))
            ->add('nombrerepresentante', null,array(
                'label'=>'NOmbre de Representante'
            ))
            ->add('direccion')
            ->add('telefono')
            ->add('idUsuario')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('nombrerepresentante')
            ->add('nombreempresa')
            ->add('direccion')
            ->add('telefono')
        ;
    }
}
