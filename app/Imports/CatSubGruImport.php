<?php

namespace App\Imports;

use App\Models\TipoAgente;
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
        return new TipoAgente([
            'idage' => $row['0'],
            'tippersona'  => $row['1'],
            'concepto'  => $row['2'],	
            'porcentajebase' => $row['3'],
            'porcentajereten'  => $row['4'],
            'mayorpago'  => $row['5'],	
            'sustraendo'  => $row['6']
        ]);
    }
}
