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
            array('tipsts'=>'contrato','sts'=>'ANU'),
            array('tipsts'=>'contrato','sts'=>'ACT'),
            array('tipsts'=>'contrato','sts'=>'RET'),
        ];
        ReglaStatus::insert($data);
    }
}
