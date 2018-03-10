<?php

namespace Utec\TransporteBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CtlempleadoAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper

            ->add('nombre')
            ->add('apellido')
            ->add('telefono')
            ->add('direccion')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper

            ->add('nombre')
            ->add('apellido')
            ->add('telefono')
            ->add('direccion')
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
        ->with('Datos Generales',array('class' => 'col-lg-4 col-md-4 col-sm-12 col-xs-12'))
            ->add('nombre')
            ->add('apellido')
            ->add('telefono')
        ->end()
        ->with('Direccion',array('class' => 'col-lg-4 col-md-4 col-sm-12 col-xs-12'))
            ->add('direccion')
            ->add('iddepartamento', null, array(
                'label'=>'Departamento de Procedencia'
            ))
        ->end()
        ->with('Otros Datos',array('class' => 'col-lg-4 col-md-4 col-sm-12 col-xs-12'))
            ->add('idcategoria',null,array(
                'label'=>'Categoria del Empleado'
            ))
            ->add('idUsuario',null,array(
                'label'=>'Usuario'
            ))
            ->add('idgenero',null,array(
                'label'=>'Genero'
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
            ->add('id')
            ->add('nombre')
            ->add('apellido')
            ->add('telefono')
            ->add('direccion')
        ;
    }
    public function getTemplate($name) {
  	switch ($name) {
      	case 'edit':
      	return 'UtecTransporteBundle::CRUD/empleado/edit.html.twig';
      	break;
      	//case 'edit2':
      	//return 'MinsalSivetvBundle::CRUD/PL-02/edit.html.twig';
      	//break;
      	default:
      	return parent::getTemplate($name);
      	break;
  	 }
    }
}
