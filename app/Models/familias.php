<?php

namespace App\Models;

use CodeIgniter\Model;

class Familias extends Model
{
    /* para el login */
    public function obtenerFami($data)
    {
        $Fami = $this->db->table('t_familias');
        $Fami->where($data);
        return $Fami->get()->getResultArray();
    }
    /* crud Fami */

    public function listarFamilias()
    {

        $Familias = $this->db->query('select * from t_familias');
        return $Familias->getResult();
    }

    public function insertar($data)
    {
        $Fami = $this->db->table('t_familias');
        $Fami->insert($data);

        return $this->db->insertID() ;
    }
    public function eliminar($data)
    {
        $Familias = $this->db->table('t_familias');
        $Familias->where($data);

        return $Familias->delete() ;
    }
    public function obteneruser($data)
    {
        $Fami = $this->db->table('t_familias');
        $Fami->where($data);
        return $Fami->get()->getResultArray();
    }
    public function actualizar($data,$id)
    {
        $Fami = $this->db->table('t_familias');
        $Fami->set($data);
        $Fami->where('id_Fami',$id);

        return $Fami->update() ;

    }
    /* fin crud Fami */
}
