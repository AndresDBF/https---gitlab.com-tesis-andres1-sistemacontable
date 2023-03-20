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
            'tipsubg'    => $row['2'],
            'tipcta'     => $row['3'],
            'descripcion'=> $row['4'],
        ]);
    }
}
