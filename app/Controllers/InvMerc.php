<?php

namespace App\Controllers;

use App\Models\Investigacion;
use Dompdf\Dompdf;
use Dompdf\Options;

class InvMerc extends BaseController
{

    public function invmercados()
    {
        if (session('usuario')) { //si no existe una session activa manda a la vista si no manda el login

            return view('invmercados/inicio');
        } else {

            return redirect()->to(base_url('/'))->with('mensaje', 'Ingresa al sistema');
        }
    }
    public function ivBuscar()
    {
        return view('invmercados/ivbuscar');
    }

    
    public function ivprecioscompetencia()
    {
        return view('invmercados/ivprecioscompetencia');
    }
    public function ivcompetencia()
    {
        return view('invmercados/ivcompetencia');
    }
    public function ivregistrarcompetencia()
    {
        /*  $contra = password_hash($_POST['contra'], PASSWORD_DEFAULT); //para encriptrar */
     /*    print_r($_REQUEST);
        exit; */
        $cc = $_POST['cc'];
        $bd = $_POST['bd'];

        $data = [
            'competencia' =>  $_POST['competencia'],
            'precio'    =>  $_POST['precio'],
            'articulo'    =>  $_POST['articulo'],

        ];
        $Investigacion = new Investigacion();
        $respuesta = $Investigacion->insertar($data);
       /*  $Home = new Home();//envia el correo 
        $Home->SendEmail(); */

       

   

       echo $respuesta;

    }


    public function ivactualizarcompetencia()
    {
        /*  $contra = password_hash($_POST['contra'], PASSWORD_DEFAULT); //para encriptrar */
         /*    print_r($_REQUEST);
        exit; */
        $cc = $_POST['cc'];
        $bd = $_POST['bd'];
        $id = $_POST['id'];
        $fechaActual = date('Y-m-d H:i:s');
        $data = [
            'precio'    =>  $_POST['precio'],
            'fecha' =>  "$fechaActual",

        ];
  
        $Investigacion = new Investigacion();
        $respuesta = $Investigacion->actualizar($data , $id);
       /*  $Home = new Home();//envia el correo 
        $Home->SendEmail(); */

        if (isset($respuesta)) {
            $datos = ['mensaje' => $respuesta];

        } else {

            $datos = ['mensaje' => $respuesta];

        }

        return $fechaActual;
    }
    /* GENERADOR DE PDF */

    public function GenerarPDF()
    {

        $dompdf = new Dompdf();
        $dompdf->loadHtml('hello world');

        $dompdf->setPaper('A4', 'landscape');

        $dompdf->render();

        /*  $dompdf->stream('Articulos.pdf'); //para descargar  */
        $dompdf->stream('Articulos.pdf', ['Attachment' => 1]); //para abrir en el navegador

    }
    public function ViewPDF()
    {

        /*    print_r($_POST);
        exit; */
        $data = [
            'DocNum' =>  $_GET['DocNum'],
            'schema' =>  $_GET['schema'],


        ];
        $html = view('invmercados/TablaPDF', $data); // ENVIA LA DATA A LA VISTA PARA IMPRIMIR EL PDF
        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);
        $dompdf = new Dompdf($options);
        $dompdf->setPaper('letter', 'landscape');
        $dompdf->loadHtml($html);
        $dompdf->render();
        $dompdf->stream('Articulos.pdf', ['Attachment' => 1]); //para abrir en el navegador

    }
    /* END GENERADOR DE PDF */
}
