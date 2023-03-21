<?php

namespace App\Exports;

use App\Models\CatCuenta;
use Maatwebsite\Excel\Concerns\FromCollection;

class CatCuentaExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return CatCuenta::all();
    }
}
