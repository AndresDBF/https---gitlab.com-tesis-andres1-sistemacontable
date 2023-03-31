<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConceptoFact;
use App\Models\TipPago;
use App\Models\Factura;
use App\Models\DetFact;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class FacturasController extends Controller
{
    public function createinvoiceing(){
        
        $conceptoFact = new ConceptoFact();
        $query = ConceptoFact::orderBy('idcfact','desc')
                               ->take(1)
                               ->get();
                               
            $values = count($query);
            if ($values == 0){
                $idcfact = 1;
                $conceptoFact = new ConceptoFact();
                $conceptoFact-> $idcfact;
                $conceptoFact->num_ing = rand(100000,999999);
                $conceptoFact->num_egre = null;
                $conceptoFact->save();
                
                
            }
            else{
                $idcfact = $query[0]->idcfact+1;
                $conceptoFact = new ConceptoFact();
                $conceptoFact-> $idcfact;
                $conceptoFact->num_ing = rand(100000,999999);
                $conceptoFact->num_egre = null;
                $conceptoFact->save();
                
            }
            $conceptoFact->idcfact = $idcfact;
            $tippag = TipPago::orderBy('descripcion')
                             ->get();
            $fecemi = Carbon::now()
                            ->format('d/m/y');
        
        return view('invoice/create')
                ->with('numing',$conceptoFact->idcfact)
                ->with('fecemi',$fecemi)
                ->with('tippag',$tippag);
    }

    public function storeinvoiceing(Request $request){
       $query = Factura::orderBy('idfact','desc')
                        ->take(1)
                        ->get();
        $values = count($query);
            if ($values == 0){

                $idfact = 1;
                $invoice = new Factura();
                $invoice->idfact = $idfact;
                $invoice->idcfact = $request->get('numreling');
                $invoice->nomacre = $request->get('name');
                $invoice->dirfact = $request->get('direction');
                $invoice->tipid = $request->get('tipid');
                $invoice->identificacion = $request->get('identification');
                if ($request->get('tiprif')== "Seleccionar Numero"){
                    $invoice->tiprif = null;
                }
                else{
                    $invoice->tiprif = $request->get('tiprif'); 
                }
                $invoice->telefono = $request->get('phone');
                $invoice->tip_pago = $request->get('tip_pag');
                $invoice->save();
                return redirect()->route('createdetinvoiceing')->with('fact',$invoice);
            }
            else{

                $idfact = $query[0]->idfact+1;
                $invoice = new Factura();
                $invoice->idfact = $idfact;
                $invoice->idcfact = $request->get('numreling');
                $invoice->nomacre = $request->get('name');
                $invoice->dirfact = $request->get('direction');
                $invoice->tipid = $request->get('tipid');
                $invoice->identificacion = $request->get('identification');
                if ($request->get('tiprif')== "Seleccionar Numero"){
                    $invoice->tiprif = null;
                }
                else{
                    $invoice->tiprif = $request->get('tiprif'); 
                }
                $invoice->telefono = $request->get('phone');
                $invoice->tip_pago = $request->get('tip_pag');
                $invoice->save();
               
                
                return redirect()->route('createdetinvoiceing');

            }                        
            

        

    }
    public function createdetinvoiceing(){
        $invoice = Factura::orderBy('idfact','desc')
                          ->take(1)
                          ->get();
        $tippag = TipPago::orderBy('descripcion')
                          ->get();
        $fecemi = Carbon::now()
                        ->format('d/m/y');
        return view('invoice.detinvoice')
                ->with('invoice',$invoice[0])
                ->with('tippag',$tippag)
                ->with('fecemi',$fecemi);
    }

   /*  public function storedetinvoiceing(){

    } */
    
}
