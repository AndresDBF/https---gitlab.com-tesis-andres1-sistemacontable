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
<<<<<<< HEAD
            'idgru'	     =>$row['1'],
            'tipsubg'	 =>$row['2'],
            'descripcion'=>$row['3'],
=======
            'idcta'	     =>$row['1'],
            'tipgrup'    =>$row['2'],
            'tipsubg'	 =>$row['3'],
            'descripcion'=>$row['4'],
>>>>>>> 4a51ac9c67a34874a99c2b62bd7b65a48004bf06
        ]);
    }
}
