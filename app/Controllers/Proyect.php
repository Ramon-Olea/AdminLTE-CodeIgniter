<?php

namespace App\Controllers;

use App\Models\Proyectos;
use Dompdf\Dompdf;
use Dompdf\Options;

class Proyect extends BaseController
{

    public function proyectos()
    {
        if (session('usuario')) { //si existe una session activa manda a la vista si no manda el login

            return view('proyectos/inicio');
        } else {

            return redirect()->to(base_url('/'))->with('mensaje', 'Ingresa al sistema');
        }
    }
    public function Buscar()
    {
        return view('proyectos/buscar');
    }

    public function stockdisponible()
    {
        return view('proyectos/stockdisponible');
    }
    public function transitoproduccion()
    {
        return view('proyectos/transitoproduccion');
    }
    public function factorimportacion()
    {
        return view('proyectos/factorimportacion');
    }
    public function detalleprecio()
    {
        return view('proyectos/detalleprecio');
    }
    public function TablaComparativa()
    {
        return view('proyectos/TablaComparativa');
    }
    public function cedis()
    {
        return view('proyectos/cedis');
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
        $html = view('proyectos/TablaPDF', $data); // ENVIA LA DATA A LA VISTA PARA IMPRIMIR EL PDF
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
