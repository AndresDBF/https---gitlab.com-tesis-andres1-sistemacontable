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
            array('tipmoneda'=>'USD','descripcion'=>'DOLAR ESTADOUNIDENSE'),
            array('tipmoneda'=>'BS','descripcion'=>'BOLIVARES'),
            array('tipmoneda'=>'COP','descripcion'=>'PESOS COLOMBIANOS'),
            array('tipmoneda'=>'EUR','descripcion'=>'EUROS'),
        ];

        Moneda::insert($data);
    }
}
