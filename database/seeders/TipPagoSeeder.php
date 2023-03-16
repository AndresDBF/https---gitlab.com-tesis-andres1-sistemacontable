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
            array('tippago'=>'1','descripcion'=>'ANUAL'),
            array('tippago'=>'2','descripcion'=>'MENSUAL'),
            array('tippago'=>'3','descripcion'=>'SEMESTRAL'),
            array('tippago'=>'4','descripcion'=>'TRIMESTRAL'),
        ];

        TipPago::insert($data);
    }
}
