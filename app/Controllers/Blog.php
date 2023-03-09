<?php

namespace App\Controllers;

use Dompdf\Dompdf;
use App\Models\Blogs;

class Blog extends BaseController
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


    /* obtiene los datos del formulario de login  */
    public function login()
    {
        /* $_POST['usuario']  otra forma de usar el post*/

        /* forma mas usada */
        $usuario = $this->request->getPost('usuario');
        $contra = $this->request->getPost('contra');


        $Usuario = new Blogs();
        $datosUsuario = $Usuario->obtenerUsuario(['usuario' => $usuario]);
        if (count($datosUsuario) > 0 && $contra == $datosUsuario[0]['contra']) {



            $data = [
                'id' =>  $datosUsuario[0]['id'],
                'usuario' =>  $datosUsuario[0]['usuario'],
                'rol'    => $datosUsuario[0]['rol'],
                'foto'    => $datosUsuario[0]['foto']

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

    /* blog */

    public function blog()
    {
        $mensaje = session('mensaje');

        $Data = new Blogs();
        $datosBlog = $Data->listarBlogs();
        $data = [
            'datos' =>  $datosBlog,
            'mensaje' =>  $mensaje,


        ];
        if (session('usuario')) {

            return view('blog/listado', $data);
        } else {

            return redirect()->to(base_url('/'))->with('mensaje', 'Ingresa al sistema');
        }
    }

    public function crearblog()
    {
        return view('blog/crear');
    }
    public function registrarblog()
    {
        /*  $contra = password_hash($_POST['contra'], PASSWORD_DEFAULT); //para encriptrar */

        $data = [
            'titulo' =>  $_POST['titulo'],
            'descripcion'    =>  $_POST['descripcion'],

        ];
        $B = new Blogs();
        $respuesta = $B->insertar($data);
       /*  $Home = new Home();//envia el correo 
        $Home->SendEmail(); */

        if ($respuesta > 0) {
            return redirect()->to(base_url() . '/blog')->with('mensaje', '1');
        } else {

            return redirect()->to(base_url() . '/blog')->with('mensaje', '0');
        }
    }
    public function blogactualizar()
    {
        return view('blog/actualizar');
    }

    public function blogeliminar($id)
    {

        $Usuario = new Blogs();

        $data = ['id' => $id];
        $respuesta = $Usuario->eliminar($data);
        if ($respuesta) {

            return redirect()->to(base_url() . '/blog')->with('mensaje', '4');
        } else {

            return redirect()->to(base_url() . '/blog')->with('mensaje', '5');
        }
    }
    public function obtenerblog($id)
    {
        $Usuario = new Blogs();

        $data = ['id' => $id];
        $respuesta = $Usuario->obtenerblog($data);

        $datos = ['id' => $respuesta];

        return $datos;
    }
    public function actualizar()
    {
        $id = $_POST['id'];

        $data = [
            'usuario' =>  $_POST['usuario'],
            'contra'    =>  $_POST['contra'],
            'rol'    =>  $_POST['rol'],

        ];
        $Usuario = new Blogs();
        $respuesta = $Usuario->actualizar($data, $id);
        if ($respuesta > 0) {

            return redirect()->to(base_url() . '/blog')->with('mensaje', '2');
        } else {

            return redirect()->to(base_url() . '/blog')->with('mensaje', '3');
        }
    }


    public function perfil()
    {
        return view('blog/perfil');
    }
    public function actualizarperfil()
    {
      
        $id = $_POST['id'];
        $foto_name = isset($_FILES["foto"]["name"]) ? $_FILES["foto"]["name"] : '';
        $foto_size = isset($_FILES["foto"]["size"]) ? $_FILES["foto"]["size"] : '';
        $foto_type = isset($_FILES["foto"]["type"]) ? $_FILES["foto"]["type"] : '';
        $foto_temporal = isset($_FILES["foto"]["tmp_name"]) ? $_FILES["foto"]["tmp_name"] : '';
        if ($foto_temporal == '') {
            $foto_reconvertida = '';
            $data = [
                'usuario' =>  $_POST['usuario'],
                'contra'    =>  $_POST['contra'],

            ];
        } else {
            $f1 = fopen($foto_temporal, "rb");
            $foto_reconvertida = fread($f1, $foto_size);
            $foto_reconvertida = base64_encode($foto_reconvertida);
            fclose($f1);
            $data = [
                'usuario' =>  $_POST['usuario'],
                'contra'    =>  $_POST['contra'],
                'foto'    =>   $foto_reconvertida,

            ];
        }


        $Usuario = new Blogs();
        $respuesta = $Usuario->actualizar($data, $id);
        if ($respuesta > 0) {

            return redirect()->to(base_url() . '/inicio')->with('mensaje', '6');
        } else {

            return redirect()->to(base_url() . '/inicio')->with('mensaje', '7');
        }
    }
    /* FIN blog */
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


    /* FIN  */
}
