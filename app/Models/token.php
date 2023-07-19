<?php

namespace App\Models;

use CodeIgniter\Model;

class Token extends Model
{
    /* para el login */
    public function obtenerToken($data)
    {
        $Token = $this->db->table('t_token');
        $Token->where($data);
        return $Token->get()->getResultArray();
    }
    /* crud Token */

    public function listarToken()
    {

        $Token = $this->db->query('select * from t_token');
        return $Token->getResult();
    }

    public function insertar($data)
    {
        $Token = $this->db->table('t_token');
        $Token->insert($data);

        return $this->db->insertID() ;
    }
    public function eliminar($data)
    {
        $Token = $this->db->table('t_token');
        $Token->where($data);

        return $Token->delete() ;
    }
    public function obteneruser($data)
    {
        $Token = $this->db->table('t_token');
        $Token->where($data);
        return $Token->get()->getResultArray();
    }
    public function actualizar($data,$id)
    {
        $Token = $this->db->table('t_token');
        $Token->set($data);
        $Token->where('id',$id);

        return $Token->update() ;

    }
    public function insertarpagosfibre($data)
    {
        $Token = $this->db->table('pagosfibre');
        $Token->insert($data);

        return $this->db->insertID() ;
    }
    public function insertarpagosoptronics($data)
    {
        $Token = $this->db->table('pagosoptronics');
        $Token->insert($data);

        return $this->db->insertID() ;
    }
    /* fin crud Token */
}
