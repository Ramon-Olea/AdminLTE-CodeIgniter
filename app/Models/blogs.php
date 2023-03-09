<?php

namespace App\Models;

use CodeIgniter\Model;

class Blogs extends Model
{
    /* para el login */
    public function obtenerUsuario($data)
    {
        $Usuario = $this->db->table('t_blog');
        $Usuario->where($data);
        return $Usuario->get()->getResultArray();
    }
    /* crud usuario */

    public function listarBlogs()
    {

        $Usuarios = $this->db->query('select * from t_blog');
        return $Usuarios->getResult();
    }

    public function insertar($data)
    {
        $Usuario = $this->db->table('t_blog');
        $Usuario->insert($data);

        return $this->db->insertID() ;
    }
    public function eliminar($data)
    {
        $Usuarios = $this->db->table('t_blog');
        $Usuarios->where($data);

        return $Usuarios->delete() ;
    }
    public function obteneruser($data)
    {
        $Usuario = $this->db->table('t_blog');
        $Usuario->where($data);
        return $Usuario->get()->getResultArray();
    }
    public function actualizar($data,$id)
    {
        $Usuario = $this->db->table('t_blog');
        $Usuario->set($data);
        $Usuario->where('id_usuario',$id);

        return $Usuario->update() ;

    }
    /* fin crud usuario */
}
