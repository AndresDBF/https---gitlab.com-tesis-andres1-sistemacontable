<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\DetFact;
use App\Models\Factura;

class ComprIngController extends Controller
{
    public function findInvoice()
    {
        return view('proof.find');
    }
    public function getIdentification ($tipid,$identification,$numcheck){

        $valueIdentif = Factura::where('tipid',$tipid)
                                ->where('identificacion',$identification)
                                ->where('tiprif',$numcheck)
                                ->get();
        return response()->json($valueIdentif);
    }

}
