<?php

namespace Application\ApiSecurityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class ApiSecurityController extends Controller
{
    /**
     * @Route("/checkin", name="application_api_checkin", options={"expose"=true})
     * @Method({"GET"})
     */
    public function checkInAction() {
        $request = $this->getRequest();

        $authenticator = $this->container->get('api.authenticator');

        $username = $request->get('user');
        $password = $request->get('password');

        try {
            $sigInData = $authenticator->signIn($username, $password);
        } catch (\Exception $e) {
            throw $e;
        }

        return new Response(json_encode($sigInData));
    }

    /**
     * @Route("/check/token", name="application_api_check_token", options={"expose"=true})
     * @Method({"GET"})
     */
    public function checkTokenAction() {
        $request = $this->getRequest();

        $guid = $request->get('token');
        $authenticator = $this->container->get('api.authenticator');

        try {
            $validGuidData = $authenticator->isValidGuid($guid);
        } catch (\Exception $e) {
            throw $e;
        }

        return new Response(json_encode($validGuidData));
    }

    /**
     * @Route("/isgranted", name="application_api_isgranted", options={"expose"=true})
     * @Method({"GET"})
     */
    public function isGrantedAction() {
        $request = $this->getRequest();

        $guid = $request->get('token');
        $role = $request->get('role');
        $authenticator = $this->container->get('api.authenticator');

        try {
            $isGranted = $authenticator->isGranted($guid, $role);
        } catch (\Exception $e) {
            throw $e;
        }

        return new Response(json_encode($isGranted ? 'true' : 'false'));
    }

    /**
     * @Route("/checkout", name="application_api_check_out", options={"expose"=true})
     * @Method({"GET"})
     */
    public function checkOutAction() {
        $request = $this->getRequest();

        $guid    = $request->get('token');
        $authenticator = $this->container->get('api.authenticator');

        try {
            $signOutData = $authenticator->signOut($guid);
        } catch (\Exception $e) {
            throw $e;
        }

        return new Response(json_encode($signOutData ? 'true' : 'false'));
    }
}
