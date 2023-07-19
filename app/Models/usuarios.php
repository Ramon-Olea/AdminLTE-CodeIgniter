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
    public function listarAreas()
    {

        $Usuarios = $this->db->query('select * from t_areas where activo ="si" ');
        return $Usuarios->getResult();
    }
    public function listarSubmodulo()
    {

        $Submodulo = $this->db->query('select ts.* ,sm.modulo 
        FROM t_submodulos ts 
        INNER JOIN t_modulos sm ON sm.id_modulo  = ts.Modulo');
        return $Submodulo->getResult();
    }
    public function listarModulo()
    {

        $modulo = $this->db->query('select *
        FROM t_modulos');
        return $modulo->getResult();
    } public function insertarSubmodulo($data)
    {
        $Usuario = $this->db->table('t_submodulos');
        $Usuario->insert($data);

        return $this->db->insertID();
    }
    public function listarSubM($id)
    {

        $modulo = $this->db->query('select ts.* ,sm.modulo 
        FROM t_submodulos ts 
        INNER JOIN t_modulos sm ON sm.id_modulo  = ts.Modulo where id_submodulo ='.$id.'');
        return $modulo->getResult();
    }
    public function editarmodulo($data, $id)
    {
        $Usuario = $this->db->table('t_submodulos');
        $Usuario->set($data);
        $Usuario->where('id_submodulo', $id);

        return $Usuario->update();
    }
    public function eliminarmodulo($data)
    {
        $Usuarios = $this->db->table('t_submodulos');
        $Usuarios->where($data);

        return $Usuarios->delete();
    }

    /* USUARIOS */
    public function insertar($data)
    {
        $Usuario = $this->db->table('t_usuarios');
        $Usuario->insert($data);

        return $this->db->insertID();
    }
    public function eliminar($data)
    {
        $Usuarios = $this->db->table('t_usuarios');
        $Usuarios->where($data);

        return $Usuarios->delete();
    }
    public function obteneruser($data)
    {
        $Usuario = $this->db->table('t_usuarios');
        $Usuario->where($data);
        return $Usuario->get()->getResultArray();
    }
    public function actualizar($data, $id)
    {
        $Usuario = $this->db->table('t_usuarios');
        $Usuario->set($data);
        $Usuario->where('id_usuario', $id);

        return $Usuario->update();
    }
    /* fin crud usuario */

    /* CRUD DE PERMISOS POR USUARIOS */

    public function eliminarPermisos($data)
    {
        $Usuarios = $this->db->table('t_permisos');
        $Usuarios->where($data);

        return $Usuarios->delete();
    }
    public function insertarPermisos($data)
    {
        $Usuario = $this->db->table('t_permisos');
        $Usuario->insert($data);

        return $this->db->insertID();
    }
    public function ConsultaInnerServerside()
    {
        $builder =$this->db->table('t_submodulos t')->select('t.Submodulo, r.modulo, t.Icono, t.Submodulo,t.Activo,t.id_submodulo');
        return $builder->join('t_modulos r', 'r.id_modulo = t.Modulo');

    }
    /* END CRUD PERMISOS */
}
