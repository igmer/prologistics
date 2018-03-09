<?php
namespace Application\SoapBundle\Service;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\Exception\CredentialsExpiredException;

class SoapClientService {

    /*
     * Codigo de Errores:
     *  ER0000 - No hay errores.
     *  ER0001 - Error en la creación del nuevo Cliente Soap.
     *  ER0002 - El Cliente Soap no es una instancia de SoapClient.
     *  ER0003 - El método soapCall del Cliente Soap produjo un error.
     *  ER0004 - No se pudo establecer conexión con el servidor a través de la URL.
     *  ER0005 - Algunos de los parámetros no ha sido definido.
     *  ER0006 - El servidor retornó un error al ejecutar el método solicitado.
     *  ER0007 - La URL proporcionada es null o es una cadena vacía al realizar el Test de Conexión.
     */

    private $url;
    private $trace;
    private $exceptions;
    private $codeInfo;
    private $statusInfo;
    private $msjInfo;
    private $location;
    private $timeOut;
    protected $soapClient;

    public function getUrl() {
        return $this->url;
    }

    public function setUrl($url) {
        $this->url = $url;

        return $this;
    }

    public function getTrace() {
        return $this->trace;
    }

    public function setTrace($trace) {
        $this->trace = $trace;

        return $this;
    }

    public function getExceptions() {
        return $this->exceptions;
    }

    public function setExceptions($exceptions) {
        $this->exceptions = $exceptions;

        return $this;
    }

    public function getCodeInfo() {
        return $this->codeInfo;
    }

    public function getStatusInfo() {
        return $this->statusInfo;
    }

    public function getmsjInfo() {
        return $this->msjInfo;
    }

    public function getLocation() {
        return $this->location;
    }

    public function setLocation($location) {
        $this->location = $location;

        return $this;
    }

    public function setTimeOut($timeOut) {
        $this->timeOut = $timeOut;

        return $this;
    }

    public function __construct($trace = true, $exceptions = true, $location = null) {
        ini_set('soap.wsdl_cache_enabled', '0');
        ini_set('soap.wsdl_cache_ttl', '0');

        $this->trace      = $trace;
        $this->exceptions = $exceptions;
        $this->codeInfo   = 'ER0000';
        $this->statusInfo = true;
        $this->msjInfo    = 'Sin errores';
        $this->location   = $location;
    }

    public function createSoapClient() {
        $this->validateParameters();

        if($this->statusInfo === false) {
            throw new \Exception($this->msjInfo);
        }

        $test = $this->testConection();

        if($test === false) {
            throw new \Exception($this->msjInfo);
        }

        $parameters = array('trace' => $this->trace, 'exceptions' => $this->exceptions);

        if($this->location !== null && $this->location !== '') {
            $parameters['location'] = $this->location;
        }

        try {
            $this->soapClient = new \Soapclient($this->url, $parameters);
        } catch(\Exception $e) {
            $this->codeInfo   = 'ER0001';
            $this->statusInfo = false;
            $this->msjInfo    = 'Error al crear el nuevo SoapClient, descripción del Error: '.$e->getMessage();

            throw new \Exception('Código de Error: '.$this->codeInfo.'. Descripción del Error: '.$this->msjInfo.' Detalle del Error: '.$e->getMessage());
        }

        return $this->soapClient;
    }

    public function soapCall($action, $parameters = array()) {
        $this->validateParameters();

        if($this->statusInfo === false) {
            throw new \Exception($this->msjInfo);
        }

        $test = $this->testConection();

        if($test === false) {
            throw new \Exception($this->msjInfo);
        }

        if(!$this->soapClient instanceof \Soapclient) {
            $this->codeInfo   = 'ER0002';
            $this->statusInfo = false;
            $this->msjInfo    = 'El cliente soap debe ser una instancia de SoapClient';

            throw new \Exception($this->msjInfo);
        }

        if($this->timeOut !== null) {
            ini_set('default_socket_timeout', $this->timeOut);
        }

        try {
            $result = $this->soapClient->__soapCall($action, $parameters);
        } catch(\Exception $e) {
            $this->codeInfo   = 'ER0003';
            $this->statusInfo = false;
            $this->msjInfo    = 'Error en la llamada del método: '.$action.', con los parámetros: '.implode(', ',$parameters);

            throw new \Exception($this->msjInfo.' Detalle del Error: '.$e);
        }

        if(strpos($result, 'exception') !== false) {
            $this->codeInfo   = 'ER0006';
            $this->statusInfo = false;
            $this->msjInfo    = 'El servidor ha retornado la siguiente excepción: '.$result;

            throw new \Exception($this->msjInfo);
        }

        return $result;
    }

    public function testConection($url = null) {
        $agent = "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)";
        $ch    = curl_init();
        $url   = $url !== null ? $url : $this->url;

        if($url === null || $url === '') {
            $this->codeInfo   = 'ER0007';
            $this->statusInfo = false;
            $this->msjInfo    = 'Código de Error: '.$this->codeInfo.' Descripción del Error: Error al realizar el test de Conexión, la URL proporcionada es null o es una cadena vacía, URL: '.$url;

            return false;
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSLVERSION, 3);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        $page = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if($httpcode >= 200 && $httpcode < 400) {
            $status = true;

            $this->codeInfo   = 'ER0000';
            $this->statusInfo = true;
            $this->msjInfo    = 'Exito al conectar con el servidor a traves de la Url: '.$this->url;
        } else {
            $status = false;

            $this->codeInfo   = 'ER0004';
            $this->statusInfo = false;
            $this->msjInfo    = 'Código de Error: '.$this->codeInfo.' Descripción del Error: No se pudo establecer conexión con la URL: '.$this->url.'. Código HTTP del Error: '.$httpcode;
        }

        return $status;
    }

    private function validateParameters() {
        $error = [];

        if($this->url === null) {
            $error = 'URL';
        }

        if($this->trace === null) {
            $error = 'trace';
        }

        if($this->exceptions === null) {
            $error = 'exceptions';
        }

        if(count($error) > 0) {
            $this->codeInfo   = 'ER0005';
            $this->statusInfo = false;

            if(count($error) === 1) {
                $this->msjInfo = 'El siguiente parámetro no ha sido definido: '.$error[0];
            } else {
                $this->msjInfo = 'Los siguientes parámetros no han sido definidos: '.implode(' ', $error);
            }

        } else {
            $this->codeInfo   = 'ER0001';
            $this->statusInfo = true;
            $this->msjInfo    = 'Validación exitosa';
        }

        return;
    }
}
