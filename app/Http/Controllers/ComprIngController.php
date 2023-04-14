<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factura;
use App\Models\DetFact;
use App\Models\ConceptoFact;
use App\Models\Cliente;
use Illuminate\Support\Facades\Session;

class ComprIngController extends Controller
{
    public function searchInvoice(){
        return view("proof.find");
    }

    public function findInvoice(Request $request){
        $tipId = $request->get('tipid');
        $identification = $request->get('identification');
        $numCheck = $request->get('numcheck');
        if ($numCheck == 'Seleccionar Numero') {
            $numCheck = null;
        }
        $findInvoice = Factura::where('tipid',$tipId)   
                              ->where('identificacion',$identification)
                              ->where('tiprif',$numCheck)
                              ->get();
        $nameCli =  Cliente::select('nombre')
                           ->where('rif_cedula',$identification)
                           ->get();
        $reling = ConceptoFact::join('facturas','concepto_facts.idcfact','=','facturas.idcfact')
                              ->select('concepto_facts.num_ing')
                              ->where('facturas.identificacion',$identification)
                              ->get();
                              dd($nameCli);
        $valueInvoice = count($nameCli);
        $valueCli = count($nameCli);
        if ($valueCli > 0 && $valueCli > 0){
            return view('proof.proofincome')
                    ->with('namecli',$nameCli[0]->nombre)
                    ->with('numfact',$findInvoice[0]->numfact)
                    ->with('tippag',$findInvoice[0]->tip_pago);
        }
        else{
            Session::flash('error',"No se han encontrado Facturas con esta Identificacion");
            return redirect()->route('searchInvoice');
        }
        
    }
}
