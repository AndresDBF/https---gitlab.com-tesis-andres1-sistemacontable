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
            array('tip_proceso'=>'contr_cli','tippago'=>'ANU','descripcion'=>'ANUAL'),
            array('tip_proceso'=>'contr_cli','tippago'=>'MEN','descripcion'=>'MENSUAL'),
            array('tip_proceso'=>'contr_cli','tippago'=>'SEM','descripcion'=>'SEMESTRAL'),
            array('tip_proceso'=>'contr_cli','tippago'=>'TRI','descripcion'=>'TRIMESTRAL'),
            array('tip_proceso'=>'comprobante_ingreso','tippago'=>'EFE','descripcion'=>'EFECTIVO'),
            array('tip_proceso'=>'comprobante_ingreso','tippago'=>'TRA','descripcion'=>'TRANSFERENCIA BANCARIA'),
            array('tip_proceso'=>'comprobante_ingreso','tippago'=>'PMO','descripcion'=>'PAGO MOVIL'),
            array('tip_proceso'=>'comprobante_ingreso','tippago'=>'TDE','descripcion'=>'TARJETA DE DEBITO'),
            array('tip_proceso'=>'comprobante_ingreso','tippago'=>'TCR','descripcion'=>'TARJETA DE CREDITO'),
            
        ];

        TipPago::insert($data);
    }
}
