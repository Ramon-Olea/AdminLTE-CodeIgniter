<?php

namespace App\Models;

use CodeIgniter\Model;

class Compras extends Model
{
    public function listarPrecios()
    {

        $Investigacion = $this->db->query('select * from preciosproveedor');
        return $Investigacion->getResult();
    }

    public function insertar($data)
    {
        $Investigacion = $this->db->table('preciosproveedor');
        $Investigacion->insert($data);

        return $this->db->insertID() ;
    }
    public function actualizar($data,$articulo)
    {
        $Investigacion = $this->db->table('preciosproveedor');
        $Investigacion->set($data);
        $Investigacion->where('id',$articulo);
     
        return $Investigacion->update() ;

    }
}
