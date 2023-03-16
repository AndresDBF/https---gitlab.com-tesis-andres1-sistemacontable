<?php

namespace App\Imports;

use App\Models\CatgCuenta;
use Maatwebsite\Excel\Concerns\ToModel;

class CatgCuentaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new CatgCuenta([
            'idgcu'      => $row['0'],
            'idcta'      => $row['1'],
            'tipcta'     => $row['2'],
            'descripcion'=> $row['3'],
        ]);
    }
}
