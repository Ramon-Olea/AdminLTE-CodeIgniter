<?php

namespace App\Controllers;

use App\Models\Documentos;
use Dompdf\Dompdf;
use Dompdf\Options;

class DocNum extends BaseController
{

    public function documentos()
    {
        if (session('usuario')) { //si existe una session activa manda a la vista si no manda el login

            return view('documentos/inicio');
        } else {

            return redirect()->to(base_url('/'))->with('mensaje', 'Ingresa al sistema');
        }
    }
    public function Buscar()
    {
        return view('documentos/buscar');
    }

    public function stockdisponible()
    {
        return view('documentos/stockdisponible');
    }
    public function transitoproduccion()
    {
        return view('documentos/transitoproduccion');
    }
    public function factorimportacion()
    {
        return view('documentos/factorimportacion');
    }
    public function detalleprecio()
    {
        return view('documentos/detalleprecio');
    }
    public function TablaComparativa()
    {
        return view('documentos/TablaComparativa');
    }
    public function preciocompetencia()
    {
        return view('documentos/preciocompetencia');
    }
    public function competencia()
    {
        return view('documentos/competencia');
    }
    public function registrarcompetencia()
    {
        /*  $contra = password_hash($_POST['contra'], PASSWORD_DEFAULT); //para encriptrar */
        /* print_r($_REQUEST);
        exit; */
        $cc = $_POST['cc'];
        $bd = $_POST['bd'];

        $data = [
            'competencia' =>  $_POST['competencia'],
            'precio'    =>  $_POST['precio'],
            'articulo'    =>  $_POST['articulo'],

        ];
        $Documentos = new Documentos();
        $respuesta = $Documentos->insertar($data);
       /*  $Home = new Home();//envia el correo 
        $Home->SendEmail(); */

        if ($respuesta > 0) {
            return redirect()->to(base_url() . '/documentos?cc='.$cc.'&bd='.$bd.'')->with('mensaje', '1');
        } else {

            return redirect()->to(base_url() . '/documentos?cc='.$cc.'&bd='.$bd.'')->with('mensaje', '0');
        }
    }


    public function actualizarcompetencia()
    {
        /*  $contra = password_hash($_POST['contra'], PASSWORD_DEFAULT); //para encriptrar */
       /*  print_r($_REQUEST);
        exit; */
        $cc = $_POST['cc'];
        $bd = $_POST['bd'];
        $Articulo = $_POST['Articulo'];
        $fechaActual = date('Y-m-d H:i:s');
        $data = [
            'precio'    =>  $_POST['precio'],
            'fecha' =>  "$fechaActual",

        ];
  
        $Documentos = new Documentos();
        $respuesta = $Documentos->actualizar($data , $Articulo);
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
        $html = view('documentos/TablaPDF', $data); // ENVIA LA DATA A LA VISTA PARA IMPRIMIR EL PDF
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
