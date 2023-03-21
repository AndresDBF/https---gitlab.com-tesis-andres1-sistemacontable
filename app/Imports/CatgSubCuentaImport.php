<?php

namespace App\Imports;

use App\Models\CatgSubCuenta;
use Maatwebsite\Excel\Concerns\ToModel;

class CatgSubCuentaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new CatgSubCuenta([
            'idscu' 	  =>$row['0'],
            'idcta'	      =>$row['1'],
            'tipsubcta'	  =>$row['2'],
            'descripcion' =>$row['3'],
        ]);
    }
}
