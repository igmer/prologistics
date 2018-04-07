<?php

namespace Utec\TransporteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;




class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('UtecTransporteBundle:Default:index.html.twig');
    }
    /**
     * @Route("/obtenerModalDetalleMonitoreo/get", name="obtenerModalDetalleMonitoreo", options={"expose"=true})
     * @Method("GET")
     */
    public function getModalDetalleMonitoreoAction() {

        $em = $this->getDoctrine()->getManager();
        $request = $this->getRequest();
        $em->getConnection()->beginTransaction();

        $sql="selectmunicipio";
        $stm = $this->container->get('database_connection')->prepare($sql);
        $stm->execute();
        $municipios = $stm->fetchAll();

        $sql2="selectdepartamento";
        $stm2 = $this->container->get('database_connection')->prepare($sql2);
        $stm2->execute();
        $departamentos = $stm2->fetchAll();

        $sql3="selectipovehiculo";
        $stm3 = $this->container->get('database_connection')->prepare($sql3);
        $stm3->execute();
        $tipo = $stm3->fetchAll();

        $sql4=" selectvehiculo
                ";
        $stm4 = $this->container->get('database_connection')->prepare($sql4);
        $stm4->execute();
        $vehiculos = $stm4->fetchAll();


         return $this->render('UtecTransporteBundle::CRUD/solicitud/createModal.html.twig',array(
         'municipios'=>$municipios,
        'departamentos'=>$departamentos,
        'vehiculos'=>$vehiculos,
        'tipo'=>$tipo));
    }
}
