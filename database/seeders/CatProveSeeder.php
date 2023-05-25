<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoriaProveedor;

class CatProveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            array('tip_prove'=>'MOB','descripcion'=>'Mobiliario'),
            array('tip_prove'=>'ELE','descripcion'=>'Electronica'),
            array('tip_prove'=>'PAP','descripcion'=>'Papeleria'),
            array('tip_prove'=>'COM','descripcion'=>'Computacion'),
            array('tip_prove'=>'INT','descripcion'=>'Internet'),
            array('tip_prove'=>'SPU','descripcion'=>'Servicios Publicos'),
            array('tip_prove'=>'ALI','descripcion'=>'Alimentos'),
            array('tip_prove'=>'ALQ','descripcion'=>'Alquiler'),
            array('tip_prove'=>'MYR','descripcion'=>'Mantenimiento y Reparación'),
        ];

        CategoriaProveedor::insert($data);
    }
}
