<?php

namespace App\Controllers;

use App\Models\Logistica;
use Dompdf\Dompdf;
use Dompdf\Options;

class Logi extends BaseController
{

    public function logistica()
    {

        $mensaje = session('mensaje');

        $Logistica = new Logistica();
        $datosLogistica = $Logistica->listarficables();
        $data = [
            'datos' =>  $datosLogistica,
            'mensaje' =>  $mensaje,

        ];

        if (session('usuario')) {

            return view('logistica/inicio', $data);
        } else {

            return redirect()->to(base_url('/'))->with('mensaje', 'Ingresa al sistema');
        }
    }
    public function BuscarItem()
    {
        return view('logistica/BuscarItem');
    }


    public function preciosproveedor()
    {
        return view('logistica/preciosproveedor');
    }
    public function proveedor()
    {
        return view('logistica/proveedor');
    }
    public function registrarproveedor()
    {
        /*  $contra = password_hash($_POST['contra'], PASSWORD_DEFAULT); //para encriptrar */
        /*    print_r($_REQUEST);
        exit; */
        $cc = $_POST['cc'];
        $bd = $_POST['bd'];

        $data = [
            'proveedor' =>  $_POST['proveedor'],
            'precio'    =>  $_POST['precio'],
            'articulo'    =>  $_POST['articulo'],

        ];
        $Logistica = new Logistica();
        $respuesta = $Logistica->insertar($data);
        /*  $Home = new Home();//envia el correo 
        $Home->SendEmail(); */





        echo $respuesta;
    }
    public function ficrear()
    {
        return view('logistica/crear');
    }
    public function firegistrar()
    {

        $fechaActual = date('Y-m-d H:i:s');
        $data = [
            'nparte'    =>  $_POST['busqueda'],
            'descripcion'    =>  $_POST['desc'],
            'precioa'    =>  $_POST['precioa'],
            'tcarrete'    =>  $_POST['tamacarrete'],
            'preciob'    =>  $_POST['preciob'],
            'precioc'    =>  $_POST['precioc'],
            'cantidad'    =>  $_POST['cantcarretes'],
            'pesocontenedor'    =>  $_POST['pesocontenedor'],
            'restriccion'    =>  $_POST['restriccion'],
            'cantidadkms'    =>  $_POST['cantkms'],
            'subtotal'    =>  $_POST['subtotalusd'],
            'costocon'    =>  $_POST['costocontenedor'],
            'fi'    =>  $_POST['fi'],
            'mcarrete'    =>  $_POST['metroscarrete'],
            'fecha' =>  "$fechaActual",
            'familia'    =>  $_POST['familia'],


        ];

        $Logistica = new Logistica();
        $data2 = ['nparte' => $_POST['busqueda']];
        $respuesta = $Logistica->obtener($data2);
        $id = $respuesta[0]['id'];

        /*  $Home = new Home();//envia el correo 
        $Home->SendEmail(); */
        /* SI NO EXISTE EL ID AINSERTA SI NO ACTUALIZA */
        if (!isset($id)) {

            $respuesta2 = $Logistica->insertar($data);

            if ($respuesta2 > 0) {

                return redirect()->to(base_url() . '/logistica')->with('mensaje', '1');
            } else {

                return redirect()->to(base_url() . '/logistica')->with('mensaje', '2');
            }
        } else {
            $Logistica->actualizar($data, $id);

            return redirect()->to(base_url() . '/logistica')->with('mensaje', '3');
        }
    }
    public function updateficables()
    {
        /*  $contra = password_hash($_POST['contra'], PASSWORD_DEFAULT); //para encriptrar */
        /*   print_r($_REQUEST);
        exit;
        */
        $id = $_POST['id'];
        $fechaActual = date('Y-m-d H:i:s');
        $data = [
            'precioa'    =>  $_POST['precioa'],
            'precioc'    =>  $_POST['precio'],
            'cantidad'    =>  $_POST['cantidad'],
            'cantidadkms'    =>  $_POST['kmscontenedor'],
            'subtotal'    =>  $_POST['subtotal'],
            'costocon'    =>  $_POST['costocontenedor'],
            'fi'    =>  $_POST['fi'],
            'pesocontenedor'    =>  $_POST['peso'],
            'fecha' =>  "$fechaActual",

        ];

        $Logistica = new Logistica();
        $respuesta = $Logistica->actualizar($data, $id);
        /*  $Home = new Home();//envia el correo 
        $Home->SendEmail(); */

        if (isset($respuesta)) {
            $datos = ['mensaje' => $respuesta];
        } else {

            $datos = ['mensaje' => $respuesta];
        }

        return $fechaActual;
    }
    /* CORREO ENVIAR */
    public function SendEmail()
    {


        $email = \Config\Services::email();

        $email->setFrom('ramon.olea@splittel.com', '');
        $email->setTo('ramon.olea@splittel.com');
        /*  $email->setCC('another@another-example.com');
      $email->setBCC('them@their-example.com'); */
        $html = view('logistica/TemplateEmail');
        $email->setSubject('Sistema AI-ML');
        $email->setMessage($html);

        $email->send();
    }


    /* FIN  */
    /* ENVIO DE NOTIFICACION A LOGISTICA */
    public function Notificar()
    {
        /*  $contra = password_hash($_POST['contra'], PASSWORD_DEFAULT); //para encriptrar */
        /*  print_r($_REQUEST);
        exit; */

        $Logistica = new Logi(); //envia el correo 




        if (!$Logistica->SendEmail()) {
            $respuesta = 1;
        } else {
            $respuesta = 0;
        }

        echo $respuesta;
    }
}
