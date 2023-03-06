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
            array('nomtabla' =>'contr_clis','codproceso'=>'contrato','sts'=>'ACT'),
            array('nomtabla' =>'contr_clis','codproceso'=>'contrato','sts'=>'ANU'),
            array('nomtabla' =>'contr_clis','codproceso'=>'contrato','sts'=>'RET'),
        ];
        ReglaStatus::insert($data);
    }
}
