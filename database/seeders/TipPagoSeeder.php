<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipPago;

class TipPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            array('tippago'=>'ANU','descripcion'=>'ANUAL'),
            array('tippago'=>'MEN','descripcion'=>'MENSUAL'),
            array('tippago'=>'SEM','descripcion'=>'SEMESTRAL'),
            array('tippago'=>'TRI','descripcion'=>'TRIMESTRAL'),
        ];

        TipPago::insert($data);
    }
}
