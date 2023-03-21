<?php

namespace App\Imports;

use App\Models\CatGrupo;
use Maatwebsite\Excel\Concerns\ToModel;

class CatGrupoImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new CatGrupo([
            'idgru'      =>$row['0'],
            'idcta'	     =>$row['1'],
            'tipgrup'    =>$row['2'],
            'descripcion'=>$row['3'],
        ]);
    }
}
