<?php

namespace App\Controllers;

use Dompdf\Dompdf;
use App\Models\Usuarios;

use Hermawan\DataTables\src\DataTables;
use Hermawan\DataTables\DataTable;

class Home extends BaseController
{
    public function index()
    {
        $mensaje = session('mensaje');
        return view('login', ["mensaje" => $mensaje]);
    }

    public function inicio()
    {

        return view('inicio');
    }
    public function datos()
    {
        return view('datos');
    }
    public function select_serverside()
    {
        $Usuario = new Usuarios();
        $ConsultaServerside = $Usuario->ConsultaInnerServerside();
        return DataTable::of($ConsultaServerside)
            ->edit('Icono', function ($row) {
                return '<i class="'. $row->Icono.'"></i>';
            })->edit('Activo', function ($row) {
                $color = $row->Activo == "si" ? "green" : "red";
                return '<span  class="badge " style="background-color:'.$color.'">'.$row->Activo .'</span>';
            })->edit('id_submodulo', function ($row) {
                return '<a href="'. base_url() . '/moduloedit/' . $row->id_submodulo .'" class="btn btn-info" class="text-white">Editar </a> <a href="'. base_url() . '/modulodelete/' . $row->id_submodulo .'" class="btn btn-danger">Eliminar</a>';
            })->toJson();
    }

    /* obtiene los datos del formulario de login  */
    public function login()
    {
        /* $_POST['usuario']  otra forma de usar el post*/

        /* forma mas usada */
        $usuario = $this->request->getPost('usuario');
        $contra = $this->request->getPost('contra');


        $Usuario = new Usuarios();
        $datosUsuario = $Usuario->obtenerUsuario(['usuario' => $usuario]);
        if (count($datosUsuario) > 0 && $contra == $datosUsuario[0]['contra']) {



            $data = [
                'id_usuario' =>  $datosUsuario[0]['id_usuario'],
                'usuario' =>  $datosUsuario[0]['usuario'],
                'rol'    => $datosUsuario[0]['rol'],
                'foto'    => $datosUsuario[0]['foto'],
                'email'    => $datosUsuario[0]['email']


            ];


            $session = session();
            $session->set($data); //agregamos los datos obtenidos  del usuario

            return redirect()->to(base_url('/inicio'))->with('mensaje', '6');
        } else {

            return redirect()->to(base_url('/'))->with('mensaje', ' Usuario o contraseña incorrectos');
        }
    }
    public function salir()
    {
        $session = session();
        $session->destroy();

        return redirect()->to(base_url('/'));
    }

    /* USUARIOS */

    public function usuarios()
    {
        $mensaje = session('mensaje');

        $Usuarios = new Usuarios();
        $datosUsuario = $Usuarios->listarUsuarios();
        $data = [
            'datos' =>  $datosUsuario,
            'mensaje' =>  $mensaje,


        ];
        if (session('usuario')) {

            return view('usuarios/listado', $data);
        } else {

            return redirect()->to(base_url('/'))->with('mensaje', 'Ingresa al sistema');
        }
    }

    public function usercrear()
    {
        $Usuarios = new Usuarios();
        $datosUsuario = $Usuarios->listarAreas();
        $data = [
            'datos' =>  $datosUsuario
        ];
        if (session('usuario')) {

            return view('usuarios/crear', $data);
        } else {

            return redirect()->to(base_url('/'))->with('mensaje', 'Ingresa al sistema');
        }
    }
    public function registrar()
    {
        /*  $contra = password_hash($_POST['contra'], PASSWORD_DEFAULT); //para encriptrar */

        $data = [
            'usuario' =>  $_POST['usuario'],
            'contra'    =>  $_POST['contra'],
            'email'    =>  $_POST['email'],
            'rol'    =>  $_POST['rol'],
            'area'    =>  $_POST['area'],

        ];
        $Usuario = new Usuarios();
        $respuesta = $Usuario->insertar($data);
        /*  $Home = new Home();//envia el correo 
        $Home->SendEmail(); */

        if ($respuesta > 0) {
            return redirect()->to(base_url() . '/usuarios')->with('mensaje', '1');
        } else {

            return redirect()->to(base_url() . '/usuarios')->with('mensaje', '0');
        }
    }
    public function useractualizar()
    {
        $Usuarios = new Usuarios();
        $datosUsuario = $Usuarios->listarAreas();
        $data = [
            'datos' =>  $datosUsuario
        ];
        if (session('usuario')) {

            return view('usuarios/actualizar', $data);
        } else {

            return redirect()->to(base_url('/'))->with('mensaje', 'Ingresa al sistema');
        }
    }

    public function usereliminar($id)
    {

        $Usuario = new Usuarios();

        $data = ['id_usuario' => $id];
        $respuesta = $Usuario->eliminar($data);
        if ($respuesta) {

            return redirect()->to(base_url() . '/usuarios')->with('mensaje', '4');
        } else {

            return redirect()->to(base_url() . '/usuarios')->with('mensaje', '5');
        }
    }
    public function userpermisos()
    {

        return view('usuarios/userpermisos');
    }
    public function addpermiso()
    {

        return view('usuarios/addpermiso');
    }
    public function permisos()
    {

        return view('usuarios/permisos');
    }
    public function obteneruser($id)
    {
        $Usuario = new Usuarios();

        $data = ['id_usuario' => $id];
        $respuesta = $Usuario->obteneruser($data);

        $datos = ['id_usuario' => $respuesta];

        return $datos;
    }
    public function actualizar()
    {
        $id = $_POST['id_usuario'];

        $data = [
            'usuario' =>  $_POST['usuario'],
            'contra'    =>  $_POST['contra'],
            'email'    =>  $_POST['email'],
            'rol'    =>  $_POST['rol'],
            'area'    =>  $_POST['area'],


        ];
        $Usuario = new Usuarios();
        $respuesta = $Usuario->actualizar($data, $id);
        if ($respuesta > 0) {

            return redirect()->to(base_url() . '/usuarios')->with('mensaje', '2');
        } else {

            return redirect()->to(base_url() . '/usuarios')->with('mensaje', '3');
        }
    }


    public function perfil()
    {
        return view('usuarios/perfil');
    }
    public function actualizarperfil()
    {
        $id = $_POST['id_usuario'];
        $foto_name = isset($_FILES["foto"]["name"]) ? $_FILES["foto"]["name"] : '';
        $foto_size = isset($_FILES["foto"]["size"]) ? $_FILES["foto"]["size"] : '';
        $foto_type = isset($_FILES["foto"]["type"]) ? $_FILES["foto"]["type"] : '';
        $foto_temporal = isset($_FILES["foto"]["tmp_name"]) ? $_FILES["foto"]["tmp_name"] : '';
        if ($foto_temporal == '') {
            $foto_reconvertida = '';
            $data = [
                'usuario' =>  $_POST['usuario'],
                'contra'    =>  $_POST['contra'],
                'email'    =>  $_POST['email'],

            ];
        } else {
            $f1 = fopen($foto_temporal, "rb");
            $foto_reconvertida = fread($f1, $foto_size);
            $foto_reconvertida = base64_encode($foto_reconvertida);
            fclose($f1);
            $data = [
                'usuario' =>  $_POST['usuario'],
                'contra'    =>  $_POST['contra'],
                'email'    =>  $_POST['email'],
                'foto'    =>   $foto_reconvertida,

            ];
        }


        $Usuario = new Usuarios();
        $respuesta = $Usuario->actualizar($data, $id);
        if ($respuesta > 0) {

            return redirect()->to(base_url() . '/inicio')->with('mensaje', '6');
        } else {

            return redirect()->to(base_url() . '/inicio')->with('mensaje', '7');
        }
    }
    /*  🆁🅼🅽 */
    /* CORREO ENVIAR */
    public function SendEmail()
    {
        $email = \Config\Services::email();

        $email->setFrom('ramon.olea@splittel.com', '');
        $email->setTo('ramon.olea@splittel.com');
        /*  $email->setCC('another@another-example.com');
        $email->setBCC('them@their-example.com'); */
        $html = view('documentos/TemplateEmail');
        $email->setSubject('Sistema AI-ML');
        $email->setMessage($html);

        $email->send();
    }
    public function insertapermisos()
    {
        if (isset($_POST['duallistbox_demo1'])) {


            $Usuario = new Usuarios();

            $iduser = $_POST['id_usuario'];
            $datauser = ['id_usuario' => $iduser];
            $respuesta = $Usuario->eliminarPermisos($datauser);

            if ($respuesta) {
                foreach ($_POST['duallistbox_demo1'] as $elemento) {
                    $dato = [
                        'id_submodulo' => $elemento,
                        'id_usuario'    =>  $iduser
                    ];
                    $respuesta = $Usuario->insertarPermisos($dato);
                }

                return redirect()->to(base_url() . '/usuarios')->with('mensaje', '6');
            } else {

                return redirect()->to(base_url() . '/usuarios')->with('mensaje', '7');
            }
        } else {

            return redirect()->to(base_url() . '/usuarios')->with('mensaje', '7');
        }
    }

    /*  🆁🅼🅽  */

    /* MODULOS && SUBMODULOS */

    public function listamodulos()
    {
        $mensaje = session('mensaje');

        $Usuarios = new Usuarios();
        $data = [
            'mensaje' =>  $mensaje,
        ];
        if (session('usuario')) {

            return view('modulos/listmodulos', $data);
        } else {

            return redirect()->to(base_url('/'))->with('mensaje', 'Ingresa al sistema');
        }
        /*  return view('modulos/listmodulos'); */
    }
    public function modulocrear()
    {
        $mensaje = session('mensaje');

        $Usuarios = new Usuarios();
        $datosModulo = $Usuarios->listarModulo();

        $data = [
            'datos' =>  $datosModulo,
            'mensaje' =>  $mensaje,


        ];
        if (session('usuario')) {

            return view('modulos/modulocrear', $data);
        } else {

            return redirect()->to(base_url('/'))->with('mensaje', 'Ingresa al sistema');
        }
        /*  return view('modulos/listmodulos'); */
    }
    public function registrarmodulo()
    {
        /*  $contra = password_hash($_POST['contra'], PASSWORD_DEFAULT); //para encriptrar */

        $data = [
            'Submodulo'    =>  $_POST['Submodulo'],
            'Modulo'    =>  $_POST['Modulo'],
            'Archivo'    =>  $_POST['Archivo'],
            'Icono'    =>  $_POST['Icono'],
            'Activo'    =>  $_POST['Activo']

        ];
        $Usuario = new Usuarios();
        $respuesta = $Usuario->insertarSubmodulo($data);
        /*  $Home = new Home();//envia el correo 
        $Home->SendEmail(); */

        if ($respuesta > 0) {
            return redirect()->to(base_url() . '/listamodulos')->with('mensaje', '1');
        } else {

            return redirect()->to(base_url() . '/listamodulos')->with('mensaje', '0');
        }
    }
    public function moduloedit($id)
    {
        $mensaje = session('mensaje');

        $Usuarios = new Usuarios();
        $datosModulo = $Usuarios->listarSubM($id);

        $data = [
            'datos' =>  $datosModulo,
            'mensaje' =>  $mensaje,

        ];
        if (session('usuario')) {

            return view('modulos/moduloedit', $data);
        } else {

            return redirect()->to(base_url('/'))->with('mensaje', 'Ingresa al sistema');
        }
    }
    public function dataeditarmodulo()
    {
        /*  $contra = password_hash($_POST['contra'], PASSWORD_DEFAULT); //para encriptrar */

        $data = [
            'Submodulo'    =>  $_POST['Submodulo'],
            'Modulo'    =>  $_POST['Modulo'],
            'Archivo'    =>  $_POST['Archivo'],
            'Icono'    =>  $_POST['Icono'],
            'Activo'    =>  $_POST['Activo']

        ];
        $id = $_POST['id_submodulo'];

        $Usuario = new Usuarios();
        $respuesta = $Usuario->editarmodulo($data, $id);
        /*  $Home = new Home();//envia el correo 
        $Home->SendEmail(); */

        if ($respuesta > 0) {
            return redirect()->to(base_url() . '/listamodulos')->with('mensaje', '2');
        } else {

            return redirect()->to(base_url() . '/listamodulos')->with('mensaje', '0');
        }
    }
    public function modulodelete($id)
    {

        $Usuario = new Usuarios();

        $data = ['id_submodulo' => $id];
        $respuesta = $Usuario->eliminarmodulo($data);
        if ($respuesta) {

            return redirect()->to(base_url() . '/listamodulos')->with('mensaje', '2');
        } else {

            return redirect()->to(base_url() . '/listamodulos')->with('mensaje', '0');
        }
    }
    /*  🆁🅼🅽  */
}
