<?php
// src/Application/CoreBundle/Menu/MenuBuilder.php

namespace Application\CoreBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerAware;

class MenuBuilder extends ContainerAware {

    private $menu;
    private $cat = array('CG' => array('label' => 'Catálogo' , 'icon' => 'fa fa-list'),
                         'AG' => array('label' => 'Administracion General' , 'icon' => 'fa fa-cog'),
                         'CO' => array('label' => 'Contrato' , 'icon' => 'fa fa-file'),
                         'SO' => array('label' => 'Solicitud' , 'icon' => 'fa fa-flag'),
                         'OT' => array('label' => 'Orden de Trabajo' , 'icon' => 'fa fa-wrench'),
                         'MP' => array('label' => 'Mantto. Preventivo' , 'icon' => 'fa fa-calendar'),
                         'US' => array('label' => 'Usuario' , 'icon' => 'fa fa-user'));

    public function mainMenu(FactoryInterface $factory, array $options) {
      $this->menu = $factory->createItem('root');
      $this->menu->setChildrenAttribute('class', 'nav navbar-nav');

      $admin = $options['admin'];
      $user = $options['user'];
        //var_dump($options);exit();
        /* Creacion del Menu dinamico */
        foreach ($admin as $key => $value) {
             if ($key == "sonata_user") {
                 $key = "US-1-Gestión de Usuario";
             }
             list($category, $level, $label) = explode("-", $key);

             $this->createDropDownMenu($value['items'], $this->cat[$category]['label'], $label, $level, $this->cat[$category]['icon']);
         }

        /* Creacion del menu estatico */
        $this->createStaticMenu($user);

        $this->menu->addChild('Ayuda')->setAttribute('dropdown', true)->setAttribute('icon', 'fa fa-question-circle');
        $this->menu['Ayuda']->addChild('Acerca de', array('uri' => '#myModal'))
                ->setLinkAttribute('id', 'about_info_modal')
                ->setLinkAttribute('custom-modal', 'true')
                ->setLinkAttribute('role', 'button')
                ->setLinkAttribute('btnCustom', 'true')
                ->setLinkAttribute('data-toggle', 'modal')
                ->setLinkAttribute('tabindex', '-1');

        return $this->menu;
    }

    private function countItemsGranted(array $items) {
        $array = array();

        foreach ($items as $key => $object) {
            if ($object->hasroute('list') && $object->isGranted('LIST')) {
                if ($object->getLabel() == "groups") {
                    $array[] = array('label' => "Grupos", 'url' => $object->generateUrl('list'));
                } else if ($object->getLabel() == "users") {
                        $array[] = array('label' => "Usuarios", 'url' => $object->generateUrl('list'));
                    } else {
                        $array[] = array('label' => $object->getLabel(), 'url' => $object->generateUrl('list'));
                    }
            }
        }

        return $array;
    }

    private function createDropDownMenu($object, $catLabel, $label, $level, $icon) {
        $contMenu = $this->countItemsGranted($object);

        if (count($contMenu) != 0) {
            if (!$this->menu[$catLabel]) {
                $this->menu->addChild($catLabel)->setAttribute('dropdown', true)->setAttribute('icon', $icon);
            }

            switch ($level) {
                case '1':
                    foreach ($contMenu as $keya => $itema) {
                        $this->menu[$catLabel]->addChild($itema['label'], array('uri' => $itema['url']));
                    }
                    break;
                case '2':
                    if (!$this->menu[$catLabel][$label]) {
                        $this->menu[$catLabel]->addChild($label)->setAttribute('dropdown', true);
                    }

                    foreach ($contMenu as $keyb => $itemb) {
                        $this->menu[$catLabel][$label]->addChild($itemb['label'], array('uri' => $itemb['url']));
                    }
                    break;

                default:

                    break;
            }
        }
    }

    private function createStaticMenu($user) {
        /*
         * Ejemplo de Creacion de Menu Estatico, descomentar para su funcionamiento
         */
        /*if($user->hasRole('ROLE_USER_LISTAREXPEDIENTES') || $user->hasRole('ROLE_SUPER_ADMIN'))
            $this->menu['Reporte']->addChild('Expedientes Creados por Usuario', array('route' => 'admin_minsal_siaps_mntexpediente_listarexpedientes'));
        if($user->hasRole('ROLE_USER_BUSCAREMERGENCIA') || $user->hasRole('ROLE_SUPER_ADMIN')){
            $this->menu['Identificación Paciente']->addChild('Registrar Emergencia', array('route' => 'admin_minsal_siaps_mntpaciente_buscaremergencia'));
            $this->menu['Reporte']->addChild('Emergencias por Fecha', array('route' => 'admin_minsal_seguimiento_secemergencia_resumen_emergencia'));
        }*/
    }
}
