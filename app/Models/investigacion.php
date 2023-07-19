<?php

namespace App\Models;

use CodeIgniter\Model;

class Investigacion extends Model
{
    public function listarPrecios()
    {

        $Investigacion = $this->db->query('select * from precioscompetencia');
        return $Investigacion->getResult();
    }

    public function insertar($data)
    {
        $Investigacion = $this->db->table('precioscompetencia');
        $Investigacion->insert($data);

        return $this->db->insertID() ;
    }
    public function actualizar($data,$articulo)
    {
        $Investigacion = $this->db->table('precioscompetencia');
        $Investigacion->set($data);
        $Investigacion->where('id',$articulo);
     
        return $Investigacion->update() ;

    }
}
