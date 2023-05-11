<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factura;
use App\Models\DetFact;
use App\Models\ConceptoFact;
use App\Models\Cliente;
use App\Models\Moneda;
use App\Models\TipPago;
use App\Models\DetComprobanteIng;
use App\Models\ComprobanteIngreso;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

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
        $invoiceId = $findInvoice->pluck('idfact');
        $findDetInvoice = DetFact::whereIn('idfact', $invoiceId)
                                   ->where('stsfact','ACT')
                                   ->get();      
        $nameCli =  Cliente::select('idcli','nombre')
                           ->where('identificacion',$identification)
                           ->get();
        $valueInvoice = count($nameCli);
        $valueCli = count($nameCli);    
        
        if ($valueCli > 0 && $valueCli > 0){
            return view('proof.proofincome',compact('findDetInvoice','findInvoice'))
                        ->with('nameCli',$nameCli[0]);//['detFact' => $detFact,'findInvoice' => $findInvoice, 'reling' => $reling]);
                    
        }
        else{
            Session::flash('error',"No se han encontrado Facturas con esta Identificacion");
            return redirect()->route('searchInvoice');
        }
        
    }

    public function createIncome($idfact,$idcli){
        $valueIdfact = $idfact;
        $valueIdcli = $idcli;
        $invoice = Factura::where('idfact',$valueIdfact)
                          ->first();        
        $fecTransaction =  Carbon::now()->format('d/m/y');
        $detInvoice = DetFact::where('idfact',$valueIdfact)
                             ->first();
        $money = Moneda::all();
        $formPay = TipPago::where('tip_proceso','comprobante_ingreso')
                          ->orderBy('descripcion')
                          ->get();
        return view('proof.create',compact('invoice','fecTransaction','detInvoice','money','formPay','valueIdfact','valueIdcli'));
    }

    public function storeproof(Request $request){
        $proofIncome = new ComprobanteIngreso();
        $proofIncome->idfact = $request->get('idfact');
        $proofIncome->numconfirm = $request->get('numconfirm');
        $proofIncome->numfact = $request->get('numfact');
        $proofIncome->moneda = $request->get('money');
        $proofIncome->cantidad = $request->get('amount');
        $proofIncome->cantidad_escr = $request->get('byconcept');
        $proofIncome->save();

        $detProofIncome = new DetComprobanteIng();
        $detProofIncome->idcom = $proofIncome->idcom;
        $detProofIncome->idcli = $request->get('idcli');
        $detProofIncome->nombre_cliente = $request->get('name');
        $detProofIncome->fec_trans = $request->get('fecTransiction');
        $detProofIncome->stscom = 'ACT';
        $detProofIncome->formpago = $request->get('formPay');
        $detProofIncome->descripcion = $request->get('description');
        $detProofIncome->save();

        $idfact= $request->get('idfact');
        $invoice = DetFact::find($idfact);
        $invoice->stsfact = 'PAG';
        $invoice->save();
        Session::flash('successProof','se ha realizado el comprobante de ingreso Correctamente');
            return redirect()->route('searchInvoice');
    }
}
