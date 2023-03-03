<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReglaStatus;

class ReglasStsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            array('nomtabla' =>'clientes','codproceso'=>'contrato','sts'=>'ACT'),
            array('nomtabla' =>'clientes','codproceso'=>'contrato','sts'=>'ANU'),
            array('nomtabla' =>'clientes','codproceso'=>'contrato','sts'=>'RET'),
        ];
        ReglaStatus::insert($data);
    }
}
