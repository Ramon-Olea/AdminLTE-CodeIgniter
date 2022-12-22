<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Usuario extends Seeder
{
    
    public function run()
    {
        $user = "admin";
        $contra = password_hash("123", PASSWORD_DEFAULT);
        $rol = "admin";

        $data = [
            'usuario' =>  $user,
            'contra'    =>  $contra ,
            'rol'    =>  $rol ,

        ];

     

        // Using Query Builder
        $this->db->table('t_usuarios')->insert($data);
    }
}
