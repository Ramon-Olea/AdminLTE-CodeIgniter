<?php

namespace App\Models;

use CodeIgniter\Model;

class Documentos extends Model
{
    public function listarPrecios()
    {

        $Documentos = $this->db->query('select * from precios');
        return $Documentos->getResult();
    }

    public function insertar($data)
    {
        $Documento = $this->db->table('precios');
        $Documento->insert($data);

        return $this->db->insertID() ;
    }
    public function actualizar($data,$articulo)
    {
        $Usuario = $this->db->table('precios');
        $Usuario->set($data);
        $Usuario->where('articulo',$articulo);
     
        return $Usuario->update() ;

    }
}
