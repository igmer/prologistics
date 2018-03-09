<?php
//src/Application/CoreBundle/Controller/CitCitasDiaController.php

namespace Application\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL as DBAL;
use Symfony\Component\Security\Core\SecurityContext;
use FOS\UserBundle\Model\User;
use  Doctrine\DBAL\Types\Type;

class CoreController extends Controller {

    /*
     *  Ejemplo de método para generar un reporte a través de jasperReportServer.
     *  Parámetros:
     *      name       = Nombre del reporte en el servidor de jasper.
     *      format     = Formato en que se genrará el reporte los valores posibles son: PDF | HTML
     *      path       = ruta del servidor en donde se encuentra el reporte si se envia la ruta por url
     *                   utilizar urlencode y no olvidar realizar el doce dentro de este método
     *                   ejemplo de ruta:            /reports/SIS/NombreCarpetaInterna/
     *                   ejemplo de ruta codificada: %2Freports%2FSIS%2FNombreCarpetaInterna%2F
     *      parameters = Parametros necesarios para la creación del reporte.
     */
    /**
     * @Route("/build/report/{name}/{format}/{path}/{parameters}", name="build_report", options={"expose"=true})
     * @Method("GET")
     *
     */
    public function buildReportAction($name, $format = "PDF", $path = "", $parameters) {
        $request = $this->getRequest();

        $jasperReport = $this->container->get('jasper.build.reports');
        $jasperReport->setReportName($name);
        $jasperReport->setReportFormat(strtoupper($format));
        $jasperReport->setReportPath(urldecode($path));
        $jasperReport->setReportParams($parameters);

        return $jasperReport->buildReport();
    }

    /*
     *  Ejemplo de método para enviar correo con mail.service.
     *  Parámetros:
     *      subject    = Título o Asunto del mensaje que será enviado.
     *      to         = Correo electrónico del destinatario.
     *      template   = Lugar y nombre de la vista que generará el response del correo electronico.
     *                   ejemplo de ruta:            'ApplicationCoreBundle:Mail:standardEmailLayout.html.twig'
     *                   ejemplo de ruta codificada: 'ApplicationCoreBundle%3AMail%3AstandardEmailLayout.html.twig'
     *      parameters = Parametros necesarios en la vista para la creación del correo.
     */
    /**
     * @Route("/send/mail/{subject}/{to}/{template}", name="send_mail", options={"expose"=true})
     * @Method("GET")
     *
     */
    public function sendMailAction($subject, $to, $template = null) {
        $mail = $this->container->get('mail.service');

        // Logica para obtener los parametros necesarios en el envio del correo...

        //preparando el array que se enviara a la vista
        $parameters = array();

        $mail->setMailSubject($subject);
        $mail->setMailTo($to);
        $mail->setMailTemplate($template);
        $result = $mail->sendMail($parameters);

        return $result;
    }

    /*
     *  timeInfo
     *      Función que permite saber si la sesion esta activa aún o si se ha entrado
     *      en periodo de inactividad.
     *
     *  Retorna:
     *      status = Valor Booleano true | false, que indica si la sesion ha finalizado
     *      time   = tiempo milisegundos de la ultima vez que se realizo una acción en el sistema.
     */
    /**
     * @Route("/sis/timeInfo", name="timeInfo", options={"expose"=true})
     * @Method("GET")
     *
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     * @return Response
     */
    public function timeInfo() {
        $session  = $this->container->get('session');

        $data['status'] = $session->get('lastUsed') ? true : false;
        $data['time']   = $session->get('lastUsed');

        return new Response(json_encode($data));
    }

    /*
     *  downloadFileAction
     *      Función que permite renderizar un archivo o imagen para mostrarlo
     *      o descargarlo.
     *
     *  Parametros:
     *      name:        Nombre del archivo a descargar o mostrar (en el caso de las imagenes).
     *      directory:   Directorio en el cual se encuentra el archivo o imagen, esta debe de estar dentro del directorio
     *                   uploads/ del raíz del proyecto. Ejemplo: uploads/DirectorioX, el drectorio no debe de llevar la pleca
     *                   inicial ni final Ejmeplo: Directoriox, cuya hubicacion total sería como en el ejemplo anterior.
     *      file_type:   Tipo de Archivo, document/pdf, image.
     *      disposition: inline | attachment , el primero muestra o renderiza el contenido en la misma vista (normalmente utilizado)
     *                   para mostrar imagenes, el segundo sirve para renderizar el archivo como un archivo adjunto y que permita descargarlo.
     *      thumbnail:   true | false permite renderizar la imagen o en el caso de documentos mostrar un icono referente al documento.
     *
     *  Retorna:
     *      Response con la imagen o documento renderizado o adjunto, y/o la miniatura de la imagen o icono descriptivo del documento
     *      si la imagen o ducmento no se encuentra en la ubicacion proporcionada por el parametro directory o no se tienen privilegios de lectura
     *      muestra una imagen que dice imagen no disponible o documento no disponible.
     */
    /**
     * @Route("/download/file/{name}/{directory}/{file_type}/{disposition}/{thumbnail}", name="render_download_file", options={"expose"=true})
     * @Method("GET")
     *
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     * @return Response
     */
    public function downloadFileAction($name, $directory, $file_type, $disposition = 'inline', $thumbnail = false) {
        $basePath       = substr($this->container->get('kernel')->getRootDir(), 0, -4);
        $location       = '/uploads/'.urldecode($directory).'/'.$name;
        $status         = 200;
        $formatSettings = explode("/", strtolower(urldecode($file_type)));
        $type           = array_key_exists(0, $formatSettings) ? $formatSettings[0] : 'document';
        $format         = array_key_exists(1, $formatSettings) ? $formatSettings[1] : 'unknow';

        if($thumbnail) {
            if(!file_exists($basePath.$location)) {
                if($type === 'image') {
                    $name = 'imagen-no-disponible.gif';
                } else {
                    $name = 'archivo-no-disponible.png';
                }

                $status   = 404;
                $location = '/web/bundles/applicationcore/images/'.$name;
            } else {
                if($type === 'document') {
                    switch ($format) {
                        case 'pdf':
                            $name = 'pdf.svg';
                            break;
                        default:
                            $name = 'download.svg';
                            break;
                    }

                    $location = '/web/bundles/applicationcore/images/'.$name;
                }
            }
        }

        $content = file_get_contents($basePath.$location);
        $headers = array('Content-Type' => mime_content_type($basePath.$location), 'Content-Disposition' => $disposition.'; filename="'.$name.'"');

        return new Response($content, 200, $headers);
    }
}
