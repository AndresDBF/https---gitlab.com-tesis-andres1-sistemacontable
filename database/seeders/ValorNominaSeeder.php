<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ValoresNomina;
use Carbon\Carbon;

class ValorNominaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fecsts = Carbon::now()->format('Y-m-d');
        $data = [
            array('concepto_valor' => 'Valor por Hora', 'monto_valor' => '0.96', 'fecsts' => $fecsts) ,
            array('concepto_valor' => 'Horas Extras Diurnas', 'monto_valor' => '1.44', 'fecsts' => $fecsts) ,
            array('concepto_valor' => 'Feriada', 'monto_valor' => '1.92', 'fecsts' => $fecsts) ,
            array('concepto_valor' => 'Horas Extras Nocturnas', 'monto_valor' => '1.87', 'fecsts' => $fecsts) ,
            array('concepto_valor' => 'CestaTicket', 'monto_valor' => '45', 'fecsts' => $fecsts) ,
        ];

        ValoresNomina::insert($data);
    }
}
