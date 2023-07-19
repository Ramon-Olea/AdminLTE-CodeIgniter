<?php

namespace App\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Token;

class Monex extends BaseController
{

    public function depositos()
    {
        if (session('usuario')) { //si existe una session activa manda a la vista si no manda el login

            return view('monex/depositos');
        } else {

            return redirect()->to(base_url('/'))->with('mensaje', 'Ingresa al sistema');
        }
    }
    public function cuentas()
    {
        if (session('usuario')) { //si existe una session activa manda a la vista si no manda el login

            return view('monex/cuentas');
        } else {

            return redirect()->to(base_url('/'))->with('mensaje', 'Ingresa al sistema');
        }
    }

    public function PagosFibremex()
    {
        if (session('usuario')) { //si existe una session activa manda a la vista si no manda el login

            return view('monex/PagosFibremex');
        } else {

            return redirect()->to(base_url('/'))->with('mensaje', 'Ingresa al sistema');
        }
    }
    public function PagosOptronics()
    {
        if (session('usuario')) { //si existe una session activa manda a la vista si no manda el login

            return view('monex/PagosOptronics');
        } else {

            return redirect()->to(base_url('/'))->with('mensaje', 'Ingresa al sistema');
        }
    }
    /* CORREO ENVIAR */

    public function TokenEmail()
    {
        /*   $cc = $_POST['cc']; */
        $fechaActual = date('Y-m-d H:i:s');
        $data = [
            'id_usuario' =>  session('id_usuario'),
            'fecha'    =>   $fechaActual,
            'contrato'    =>  $_POST['contrato'],
            'token'    =>  $_POST['code'],

        ];
        $Token = new Token();
        $respuesta = $Token->insertar($data);
        if (isset($respuesta)) {
            $Home = new Monex(); //envia el correo 
            $Home->SendEmail();
            return $datos = $_POST['secret'];
        } else {

            return  $datos = "error";
        }
    }
    public function pagosfibreadd()
    {
        /*  $contra = password_hash($_POST['contra'], PASSWORD_DEFAULT); //para encriptrar */

        $data = [
            'contrato'    =>  "2913317",
            'numeroCuenta' =>  $_POST['numeroCuenta'],
            'monto'    =>  $_POST['monto'],
            'iva'    =>  $_POST['iva'],
            'fechaOperacion'    =>  $_POST['fechaOperacion'],
            'fechaLiquidacion'    =>  $_POST['fechaLiquidacion'],
            'referenciaMovimiento' =>   "",
            'nota'    =>  $_POST['nota'],
            'referencia'    =>  $_POST['referencia'],
            'rfc'    =>  $_POST['rfc'],
            'divisa' =>  $_POST['divisa'],
            'folio'    =>  "",
            'codigo'    =>   "",
            'mensaje'    =>   "",
            'fecha'    =>  date('Y-m-d H:i:s'),

        ];
        $Token = new Token();
        $respuesta = $Token->insertarpagosfibre($data);
        /*  $Home = new Home();//envia el correo 
        $Home->SendEmail(); */

        if ($respuesta > 0) {
            /*  return redirect()->to(base_url() . '/PagosFibremex')->with('mensaje', '1'); */
            return view('monex/pagofibreadata');
        } else {
            return redirect()->to(base_url() . '/PagosFibremex')->with('mensaje', '0');
        }
    }
    public function pagosoptroadd()
    {
        /*  $contra = password_hash($_POST['contra'], PASSWORD_DEFAULT); //para encriptrar */

        $data = [
            'contrato'    =>  "2912731",
            'numeroCuenta' =>  $_POST['numeroCuenta'],
            'monto'    =>  $_POST['monto'],
            'iva'    =>  $_POST['iva'],
            'fechaOperacion'    =>  $_POST['fechaOperacion'],
            'fechaLiquidacion'    =>  $_POST['fechaLiquidacion'],
            'referenciaMovimiento' =>   "",
            'nota'    =>  $_POST['nota'],
            'referencia'    =>  $_POST['referencia'],
            'rfc'    =>  $_POST['rfc'],
            'divisa' =>  $_POST['divisa'],
            'folio'    =>  "",
            'codigo'    =>   "",
            'mensaje'    =>   "",
            'fecha'    =>  date('Y-m-d H:i:s'),

        ];
        $Token = new Token();
        $respuesta = $Token->insertarpagosoptronics($data);
        /*  $Home = new Home();//envia el correo 
        $Home->SendEmail(); */

        if ($respuesta > 0) {
            /*  return redirect()->to(base_url() . '/PagosFibremex')->with('mensaje', '1'); */
            return view('monex/pagooptroadata');
        } else {
            return redirect()->to(base_url() . '/PagosOptronics')->with('mensaje', '0');
        }
    }
    public function SendEmail()
    {


        $email = \Config\Services::email();

        $email->setFrom('notificaciones-splitnet@splittel.com', 'SISTEMA');
        $email->setTo('ramon.olea@splittel.com');
        /*  $email->setCC('another@another-example.com');
        $email->setBCC('them@their-example.com'); */
        $html = view('monex/TemplateEmail');
        $email->setSubject('TOKEN DE VERIFICACION');
        $email->setMessage($html);

        $email->send();
    }
}
