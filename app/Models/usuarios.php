<?php

namespace App\Models;

use CodeIgniter\Model;

class Usuarios extends Model
{
    /* para el login */
    public function obtenerUsuario($data)
    {
        $Usuario = $this->db->table('t_usuarios');
        $Usuario->where($data);
        return $Usuario->get()->getResultArray();
    }
    /* crud usuario */

    public function listarUsuarios()
    {

        $Usuarios = $this->db->query('select * from t_usuarios');
        return $Usuarios->getResult();
    }

    public function insertar($data)
    {
        $Usuario = $this->db->table('t_usuarios');
        $Usuario->insert($data);

        return $this->db->insertID() ;
    }
    public function eliminar($data)
    {
        $Usuarios = $this->db->table('t_usuarios');
        $Usuarios->where($data);

        return $Usuarios->delete() ;
    }
    public function obteneruser($data)
    {
        $Usuario = $this->db->table('t_usuarios');
        $Usuario->where($data);
        return $Usuario->get()->getResultArray();
    }
    public function actualizar($data,$id)
    {
        $Usuario = $this->db->table('t_usuarios');
        $Usuario->set($data);
        $Usuario->where('id_usuario',$id);

        return $Usuario->update() ;

    }
    /* fin crud usuario */
}
