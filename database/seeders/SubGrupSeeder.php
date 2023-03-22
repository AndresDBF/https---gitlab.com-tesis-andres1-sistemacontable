<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CatSubGru;

class SubGrupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            array('idgru' => '1','tipsubg'=>'1.1','descripcion'=>'CIRCULANTE'),
            
        ];
        CatSubGru::insert($data);
    }
}
