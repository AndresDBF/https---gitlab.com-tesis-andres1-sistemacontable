<?php

namespace App\Imports;

use App\Models\CatSubGru;
use Maatwebsite\Excel\Concerns\ToModel;

class CatSubGruImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new CatSubGru([
            'idsgr'	     =>$row['0'],
            'idcta'	     =>$row['1'],
            'idgru'      =>$row['2'],
            'tipsubg'	 =>$row['3'],
            'descripcion'=>$row['4'],
        ]);
    }
}
