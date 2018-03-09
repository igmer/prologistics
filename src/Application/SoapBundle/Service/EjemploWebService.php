<?php

namespace Application\SoapBundle\Service;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Symfony\Component\DependencyInjection\ContainerInterface;

class EjemploWebService {

    private $container = null;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    /*
     * Método que permite obtener las especialidades de un establecimiento.
     */
    public function obtenerUsuarios() {
        $result = array();

        try {
            $em  = $this->container->get('doctrine')->getManager();
            $dql = "SELECT A FROM ApplicationSonataUserBundle:User A";

            $resultados = $em->createQuery($dql)->getResult();

            foreach ($resultados as $key => $row) {
                $result[$key]["id"]     = $row->getId();
                $result[$key]["nombre"] = $row->getUsername();
            }
        } catch(\Exception $ex) {
            return $ex->getTraceAsString();
        }
        return json_encode($result);
    }
}
