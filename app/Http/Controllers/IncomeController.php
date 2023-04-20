<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factura;
use Carbon\Carbon;
use App\Models\DetFact;
use App\Models\Cliente;
use App\Models\ContrCli;

class IncomeController extends Controller
{
    public function searchIncome(){
        return view('income.search');
    }
    
    public function findIncome(Request $request){
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
                              //dd($findInvoice);
        $invoiceId = $findInvoice->pluck('idfact');
        
        $findDetInvoice = DetFact::whereIn('idfact', $invoiceId)
                                   ->where('stsfact','PAG')
                                   ->get();  
        $nameCli =  Cliente::select('idcli','nombre')
                           ->where('rif_cedula',$identification)
                           ->get();
        return view('income.find',compact('findDetInvoice','findInvoice'))
                    ->with('nameCli',$nameCli[0]);
       /*  ->with('findInvoice',$findInvoice)
        ->with('findDetInvoice',$findDetInvoice);//,compact('findDetInvoice','findInvoice')); */
    }

    public function createIng($idfact,$idcli){
        
        return "valor de idfact =  $idfact valor de idcli =  $idcli";
    }
}
