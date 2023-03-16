<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Moneda;

class MonedaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            array('tipmoneda'=>'1','descripcion'=>'DOLAR ESTADOUNIDENSE'),
            array('tipmoneda'=>'2','descripcion'=>'BOLIVARES'),
            array('tipmoneda'=>'3','descripcion'=>'PESOS COLOMBIANOS'),
            array('tipmoneda'=>'4','descripcion'=>'EUROS'),
        ];

        Moneda::insert($data);
    }
}
