<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asiento;


class AsientoController extends Controller
{
    public function index(Request $request)
    {
        /* idasi	
        fec_asi	
        refer	
        observacion	contacto_acre	
        contacto_benf	
        idcta	
        descripcion	
        monto_deb	
        monto_hab	
        $seat = Asiento::select('') */
        
        return view('asientos.index');
    }
}
