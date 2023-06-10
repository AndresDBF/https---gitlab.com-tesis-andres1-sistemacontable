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
            array('tip_proceso'=>'contratos','tippago'=>'ANU','descripcion'=>'ANUAL'),
            array('tip_proceso'=>'contratos','tippago'=>'MEN','descripcion'=>'MENSUAL'),
            array('tip_proceso'=>'contratos','tippago'=>'SEM','descripcion'=>'SEMESTRAL'),
            array('tip_proceso'=>'contratos','tippago'=>'TRI','descripcion'=>'TRIMESTRAL'),
            array('tip_proceso'=>'ingresos_gastos','tippago'=>'EFE','descripcion'=>'EFECTIVO'),
            array('tip_proceso'=>'ingresos_gastos','tippago'=>'TRA','descripcion'=>'TRANSFERENCIA BANCARIA'),
            array('tip_proceso'=>'ingresos_gastos','tippago'=>'PMO','descripcion'=>'PAGO MOVIL'),
            array('tip_proceso'=>'ingresos_gastos','tippago'=>'TDE','descripcion'=>'TARJETA DE DEBITO'),
            array('tip_proceso'=>'ingresos_gastos','tippago'=>'TCR','descripcion'=>'TARJETA DE CREDITO'),
            
        ];

        TipPago::insert($data);
    }
}
