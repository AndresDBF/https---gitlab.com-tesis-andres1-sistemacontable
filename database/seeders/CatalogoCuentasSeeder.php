<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CatCuenta;

class CatalogoCuentasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            array('nombre_cuenta'=>'Caja','tipcta'=>'Activo','tipmov'=>'Activo-Circulante','stscta'=>'ACT','cta1'=>'1.10.01'),
            array('nombre_cuenta'=>'Clientes','tipcta'=>'Activo','tipmov'=>'Activo-Circulante','stscta'=>'ACT','cta1'=>'1.10.02'), 
            array('nombre_cuenta'=>'Bancos','tipcta'=>'Activo','tipmov'=>'Activo-Circulante','stscta'=>'ACT','cta1'=>'1.10.03'),
            array('nombre_cuenta'=>'Mobiliario y equipo de oficina','tipcta'=>'Activo','tipmov'=>'Activo No Circulante','stscta'=>'ACT','cta1'=>'1.11.01'),
            array('nombre_cuenta'=>'Proveedores','tipcta'=>'Pasivo','tipmov'=>'Pasivo a corto plazo','stscta'=>'ACT','cta1'=>'2.20.01'),
            array('nombre_cuenta'=>'Proveedores extranjeros','tipcta'=>'Pasivo','tipmov'=>'Pasivo a corto plazo','stscta'=>'ACT','cta1'=>'2.20.02'),
            array('nombre_cuenta'=>'Documentos por pagar','tipcta'=>'Pasivo','tipmov'=>'Pasivo a corto plazo','stscta'=>'ACT','cta1'=>'2.20.03'),

        ];
        CatCuenta::insert($data);
    }
}
