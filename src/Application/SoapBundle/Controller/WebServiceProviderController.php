<?php

namespace Application\SoapBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class WebServiceProviderController extends Controller {

    public function getWebServiceAction($service) {
        ini_set('soap.wsdl_cache_enabled', '0');
        ini_set('soap.wsdl_cache_ttl', '0');

        $server = new \SoapServer('bundles/applicationsoap/wsdl/'.$service.'.wsdl');

        $server->setObject($this->container->get($service));
        $response = new Response();

        $response->headers->set('Content-Type', 'text/xml; charset=UTF-8');
        ob_start();
        $server->handle();
        $response->setContent(ob_get_clean());

        return $response;
    }

}
