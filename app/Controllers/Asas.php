<?php

namespace App\Controllers;

use App\Models\Clientes;

class Asas extends BaseController
{

    public function clientes()
    {
        if (session('usuario')) { //si existe una session activa manda a la vista si no manda el login

            return view('clientes/inicio');
        } else {

            return redirect()->to(base_url('/'))->with('mensaje', 'Ingresa al sistema');
        }
    }
    public function B()
    {
        return view('clientes/buscar');
    }
    public function docdetalle()
    {
        return view('clientes/docdetalle');
    }
}
