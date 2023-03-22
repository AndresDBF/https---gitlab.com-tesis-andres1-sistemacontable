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
            'idgru'	     =>$row['1'],
            'tipsubg'	 =>$row['2'],
            'descripcion'=>$row['3'],
        ]);
    }
}
