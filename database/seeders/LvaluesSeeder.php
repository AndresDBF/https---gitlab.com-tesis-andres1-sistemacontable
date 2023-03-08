<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\lvalue;

class LvaluesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            array('tipvalue' => 'moneda', 'value' => 'BOL','descripcion' => 'Bolivares'),
            array('tipvalue' => 'moneda', 'value' => 'COP','descripcion' => 'Pesos Colombianos'),
            array('tipvalue' => 'moneda', 'value' => 'USD','descripcion' => 'Dolar Estadounidense'),
            array('tipvalue' => 'moneda', 'value' => 'EUR','descripcion' => 'Euros'),
            array('tipvalue' => 'tippago', 'value' => 'ANU','descripcion' => 'Anual'),
            array('tipvalue' => 'tippago', 'value' => 'MEN','descripcion' => 'Mensual'),
            array('tipvalue' => 'tippago', 'value' => 'SEM','descripcion' => 'Semestral'),
            array('tipvalue' => 'tippago', 'value' => 'TRI','descripcion' => 'Trimestral'),
        ];
        lvalue::insert($data);
            
    }
}
