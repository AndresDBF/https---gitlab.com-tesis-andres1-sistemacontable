<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CatCuentaImport;
use App\Imports\CatgCuentaImport;
use App\Imports\CatGrupoImport;
use App\Imports\CatgSubCuentaImport;
use App\Imports\CatSubGruImport;
use App\Models\CatCuenta;

class Importexcel extends Controller
{
    //
    public function impportar()
    {
        return view('excel/importar');
    }
    public function importarexcel(Request $request)
    {
        /* // recibir el excel y guardarlo
        $file = $request->file('file');
        $nombre =$file->getClientOriginalName();
        $destinationPath = 'uploads';// guarda el excel en la aplicacion
        $file->move($destinationPath,$file->getClientOriginalName());
        //leer le excel
        $inputFileName = './uploads/'.$nombre;
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
        $totalDeHojas = $spreadsheet->getSheetCount();
        $worksheet = $spreadsheet->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();
        $highestColumn = $worksheet->getHighestColumn();
        $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
        
        for ($row = 2; $row <= $highestRow; ++$row) // recorre filas
        {
            for ($col = 1; $col <= $highestColumnIndex; ++$col) // recorre colunas
            {
                $value = $worksheet->getCellByColumnAndRow($col, $row)->getValue(); // valor en cada celda
            }
        } */
        //Excel::import(new CatCuentaImport(), request()->file('excel'));
        //Excel::import(new CatGrupoImport(), request()->file('excel'));
        //Excel::import(new CatSubGruImport(), request()->file('excel'));
        //Excel::import(new CatgCuentaImport(), request()->file('excel'));
        Excel::import(new CatgSubCuentaImport(), request()->file('excel'));

        
        return redirect()->to(url('excel/importar'));

    }
}
