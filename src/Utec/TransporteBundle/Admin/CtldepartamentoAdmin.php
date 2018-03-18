<?php

namespace Utec\TransporteBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CtldepartamentoAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('abreviatura')
            ->add('nombre')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper

            ->add('abreviatura')
            ->add('nombre')
            ->add('departamentoDetalle')
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
          ->with('Departamento')
            ->add('abreviatura')
            ->add('nombre')
          ->end()
          ->with('Municipios del Departamento')
                ->add('departamentoDetalle','sonata_type_collection',array('label' =>'Municipios'),
                                                                 array('edit' => 'inline', 'inline' => 'table'))
            ->end()
        ;
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('abreviatura')
            ->add('nombre')
            ->add('departamentoDetalle')
        ;
    }

    public function prePersist($dep) {
           $user = $this->getConfigurationPool()->getContainer()->get('security.context')->getToken()->getUser();
       //    $can->setIdUsuarioReg($user);
           //$can->setFechaHoraReg(new \DateTime());
           foreach ($dep->getDepartamentoDetalle() as $detalle) {
               $detalle->setIddepartamento($dep);
           //    $detalle->setIdUsuarioReg($user);
            //   $detalle->setFechaHoraReg(new \DateTime());
           }
       }
       public function preUpdate($dep) {
              $user = $this->getConfigurationPool()->getContainer()->get('security.context')->getToken()->getUser();
          //    $can->setIdUsuarioReg($user);
              //$can->setFechaHoraReg(new \DateTime());
              foreach ($dep->getDepartamentoDetalle() as $detalle) {
                  $detalle->setIddepartamento($dep);
              //    $detalle->setIdUsuarioReg($user);
               //   $detalle->setFechaHoraReg(new \DateTime());
              }
          }
}
