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
            /* array('nombre_cuenta'=>'Fondo Fijo de Caja','tipcta'=>'Activo','tipmov'=>'Activo-Circulante','stscta'=>'ACT','cta1'=>'1.10.02','cta2'=>'1.10.02.01'), */
            array('nombre_cuenta'=>'Bancos','tipcta'=>'Activo','tipmov'=>'Activo-Circulante','stscta'=>'ACT','cta1'=>'1.10.03'),
            /* array('nombre_cuenta'=>'Documentos por cobrar','tipcta'=>'Activo','tipmov'=>'Activo-Circulante','stscta'=>'ACT','cta1'=>'1.10.04'),
            array('nombre_cuenta'=>'Intereses por Cobrar','tipcta'=>'Activo','tipmov'=>'Activo-Circulante','stscta'=>'ACT','cta1'=>'1.10.05'),
            array('nombre_cuenta'=>'Documentos por cobrar','tipcta'=>'Activo','tipmov'=>'Activo-Circulante','stscta'=>'ACT','cta1'=>'1.10.06'), */
        ];
        CatCuenta::insert($data);
    }
}
