<?php

namespace App\Models;

use CodeIgniter\Model;

class Logistica extends Model
{
    public function listarficables()
    {

        $Investigacion = $this->db->query('select * from ficables');
        return $Investigacion->getResult();
    }

    public function insertar($data)
    {
        $Investigacion = $this->db->table('ficables');
        $Investigacion->insert($data);

        return $this->db->insertID() ;
    }
    public function actualizar($data,$articulo)
    {
        $Investigacion = $this->db->table('ficables');
        $Investigacion->set($data);
        $Investigacion->where('id',$articulo);
     
        return $Investigacion->update() ;

    }
    public function obtener($data)
    {
        $Usuario = $this->db->table('ficables');
        $Usuario->where($data);
        return $Usuario->get()->getResultArray();
    }
}
