<?php

namespace App\Controllers;

use App\Models\Compras;
use Dompdf\Dompdf;
use Dompdf\Options;

class Compra extends BaseController
{

    public function compras()
    {
        if (session('usuario')) { //si existe una session acta manda a la vista si no manda el login

            return view('compras/inicio');
        } else {

            return redirect()->to(base_url('/'))->with('mensaje', 'Ingresa al sistema');
        }
    }
    public function Buscar()
    {
        return view('compras/buscar');
    }

 
    public function preciosproveedor()
    {
        return view('compras/preciosproveedor');
    }
    public function proveedor()
    {
        return view('compras/proveedor');
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
        $Compras = new Compras();
        $respuesta = $Compras->insertar($data);
       /*  $Home = new Home();//envia el correo 
        $Home->SendEmail(); */

       

   

       echo $respuesta;

    }


    public function actualizarproveedor()
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
  
        $Compras = new Compras();
        $respuesta = $Compras->actualizar($data , $id);
       /*  $Home = new Home();//envia el correo 
        $Home->SendEmail(); */

        if (isset($respuesta)) {
            $datos = ['mensaje' => $respuesta];

        } else {

            $datos = ['mensaje' => $respuesta];

        }

        return $fechaActual;
    }
  
}
