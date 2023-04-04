<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConceptoFact;
use App\Models\TipPago;
use App\Models\Factura;
use App\Models\DetFact;
use App\Models\DescripcionFactura;
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
                //insert in table det_fact
                $detInvoice = new DetFact();
                $detInvoice->iddfact = $idfact;
                $detInvoice->idfact = $idfact;
                $detInvoice->numfact = $request->get('numfact');
                $detInvoice->numctrl = $request->get('numctrl');
                $detInvoice->stsfact = 'ACT';
                $detInvoice->fec_emi = $request->get('fecemi');
                $detInvoice->save();
                $numConcept = $request->get('numconcept');
                return redirect()->route('createdetinvoiceing',$numConcept);
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
                //insert in table det_fact
                $detInvoice = new DetFact();
                $detInvoice->iddfact = $idfact;
                $detInvoice->idfact = $idfact;
                $detInvoice->numfact = $request->get('numfact');
                $detInvoice->numctrl = $request->get('numctrl');
                $detInvoice->stsfact = 'ACT';
                $detInvoice->fec_emi = $request->get('fecemi');
                $detInvoice->save();
                $numConcept = $request->get('numconcept');
                return redirect()->route('createdetinvoiceing',$numConcept);

            }                        
            

        

    }
    public function createdetinvoiceing($numConcept){
        $cantConcept = $numConcept;
        $invoice = Factura::orderBy('idfact','desc')
                          ->take(1)
                          ->get();

        $detInvoice = DetFact::orderBy('iddfact','desc')
                             ->take(1)
                             ->get();
                             
        $tippag = TipPago::orderBy('descripcion')
                          ->get();
        return view('invoice.detinvoice')
                ->with('invoice',$invoice[0])
                ->with('tippag',$tippag)
                ->with('detInvoice',$detInvoice[0])
                ->with('cantConcept',$cantConcept);

    }

    public function storedetinvoiceing(Request $request){
        $query = DescripcionFactura::orderBy('iddfact','desc')
                                    ->take(1)
                                    ->get();      
        $iddfact = $query[0]->iddfact;  
        dd($iddfact);
        $queryFact = Factura::orderBy('idfact','desc')
                            ->take(1)
                            ->get();
        $idfact = $queryFact[0]->idfact;  
        $values = count($query);
        if ($values == 0){
            $iddfact = 1;
            //condition for number conceptFact
            if ($request->get('numconcept')==1){
                $conceptFact = new DescripcionFactura();
                $conceptFact->idfact = $request->get('numreling');
                $conceptFact->descripcion = $request->get("concept_0");
                $conceptFact->monto_unitario = $request->get("amountUnit_0");
                $conceptFact->monto_bien = $request->get("amountService_0");
                $conceptFact->save();
            }
            if ($request->get('numconcept')==2){
                for ($i=0; $i <= 1 ; $i++) { 
                    if ($i == 0){
                        $conceptFact = new DescripcionFactura();
                        $conceptFact->idfact = $queryFact[0]->idfact;
                        $conceptFact->descripcion = $request->get("concept_0");
                        $conceptFact->monto_unitario = $request->get("amountUnit_0");
                        $conceptFact->monto_bien = $request->get("amountService_0");
                        $conceptFact->save();
                    }
                    if ($i == 1){
                        $conceptFact = new DescripcionFactura();
                        $conceptFact->idfact = $queryFact[0]->idfact;
                        $conceptFact->descripcion = $request->get("concept_1");
                        $conceptFact->monto_unitario = $request->get("amountUnit_1");
                        $conceptFact->monto_bien = $request->get("amountService_1");
                        $conceptFact->save();
                    }
                    
                    
                }
                
            }
            if ($request->get('numconcept')==3){
                for ($i=0; $i < 3; $i++) { 
                    
                    if ($i == 0){
                        $conceptFact = new DescripcionFactura();
                        $conceptFact->idfact = $queryFact[0]->idfact;
                        $conceptFact->descripcion = $request->get("concept_0");
                        $conceptFact->monto_unitario = $request->get("amountUnit_0");
                        $conceptFact->monto_bien = $request->get("amountService_0");
                        $conceptFact->save();
                    }
                    if ($i == 1){
                        $conceptFact = new DescripcionFactura();
                        $conceptFact->idfact = $queryFact[0]->idfact;
                        $conceptFact->descripcion = $request->get("concept_1");
                        $conceptFact->monto_unitario = $request->get("amountUnit_1");
                        $conceptFact->monto_bien = $request->get("amountService_1");
                        $conceptFact->save();
                    }
                    if ($i == 2){
                        $conceptFact = new DescripcionFactura();
                        $conceptFact->iddfact = $iddfact+1;
                        $conceptFact->idfact = $queryFact[0]->idfact;
                        $conceptFact->descripcion = $request->get("concept_2");
                        $conceptFact->monto_unitario = $request->get("amountUnit_2");
                        $conceptFact->monto_bien = $request->get("amountService_2");
                        $conceptFact->save();
                    }
                }
                
            }
            if ($request->get('numconcept')==4){
                
                if ($i == 0){
                    $conceptFact = new DescripcionFactura();
                    $conceptFact->idfact = $queryFact[0]->idfact;
                    $conceptFact->descripcion = $request->get("concept_0");
                    $conceptFact->monto_unitario = $request->get("amountUnit_0");
                    $conceptFact->monto_bien = $request->get("amountService_0");
                    $conceptFact->save();
                }
                if ($i == 1){
                    $conceptFact = new DescripcionFactura();
                    $conceptFact->idfact = $queryFact[0]->idfact;
                    $conceptFact->descripcion = $request->get("concept_1");
                    $conceptFact->monto_unitario = $request->get("amountUnit_1");
                    $conceptFact->monto_bien = $request->get("amountService_1");
                    $conceptFact->save();
                }
                if ($i == 2){
                    $conceptFact = new DescripcionFactura();
                    $conceptFact->idfact = $queryFact[0]->idfact;
                    $conceptFact->descripcion = $request->get("concept_2");
                    $conceptFact->monto_unitario = $request->get("amountUnit_2");
                    $conceptFact->monto_bien = $request->get("amountService_2");
                    $conceptFact->save();
                }
                if ($i == 3){
                    $conceptFact = new DescripcionFactura();
                    $conceptFact->idfact = $queryFact[0]->idfact;
                    $conceptFact->descripcion = $request->get("concept_3");
                    $conceptFact->monto_unitario = $request->get("amountUnit_3");
                    $conceptFact->monto_bien = $request->get("amountService_3");
                    $conceptFact->save();
                }
               
            }
            if ($request->get('numconcept')==5){
                
                if ($i == 0){
                    $conceptFact = new DescripcionFactura();
                    $conceptFact->idfact = $queryFact[0]->idfact;
                    $conceptFact->descripcion = $request->get("concept_0");
                    $conceptFact->monto_unitario = $request->get("amountUnit_0");
                    $conceptFact->monto_bien = $request->get("amountService_0");
                    $conceptFact->save();
                }
                if ($i == 1){
                    $conceptFact = new DescripcionFactura();
                    $conceptFact->idfact = $queryFact[0]->idfact;
                    $conceptFact->descripcion = $request->get("concept_1");
                    $conceptFact->monto_unitario = $request->get("amountUnit_1");
                    $conceptFact->monto_bien = $request->get("amountService_1");
                    $conceptFact->save();
                }
                if ($i == 2){
                    $conceptFact = new DescripcionFactura();
                    $conceptFact->idfact = $queryFact[0]->idfact;
                    $conceptFact->descripcion = $request->get("concept_2");
                    $conceptFact->monto_unitario = $request->get("amountUnit_2");
                    $conceptFact->monto_bien = $request->get("amountService_2");
                    $conceptFact->save();
                }
                if ($i == 3){
                    $conceptFact = new DescripcionFactura();
                    $conceptFact->idfact = $request->$queryFact[0]->idfact;
                    $conceptFact->descripcion = $request->get("concept_3");
                    $conceptFact->monto_unitario = $request->get("amountUnit_3");
                    $conceptFact->monto_bien = $request->get("amountService_3");
                    $conceptFact->save();
                }
                if ($i == 4){
                    $conceptFact = new DescripcionFactura();
                    $conceptFact->idfact = $request->$queryFact[0]->idfact;
                    $conceptFact->descripcion = $request->get("concept_4");
                    $conceptFact->monto_unitario = $request->get("amountUnit_4");
                    $conceptFact->monto_bien = $request->get("amountService_4");
                    $conceptFact->save();
                }
               
            }      
            
            return redirect()->route('totalinvoice',$idfact,$iddfact);
        
        }
        else{
            $iddfact = $query[0]->iddfact+1;
            
            //condition for number conceptFact
            if ($request->get('numconcept')==1){
                $conceptFact = new DescripcionFactura();
                $conceptFact->idfact = $queryFact[0]->idfact;
                $conceptFact->descripcion = $request->get("concept_0");
                $conceptFact->monto_unitario = $request->get("amountUnit_0");
                $conceptFact->monto_bien = $request->get("amountService_0");
                $conceptFact->save();
            }

            if ($request->get('numconcept')==2){
                for ($i=0; $i < 2 ; $i++){ 
                    if ($i == 0){
                        $conceptFact = new DescripcionFactura();
                        $conceptFact->idfact = $queryFact[0]->idfact;
                        $conceptFact->descripcion = $request->get("concept_0");
                        $conceptFact->monto_unitario = $request->get("amountUnit_0");
                        $conceptFact->monto_bien = $request->get("amountService_0");
                        $conceptFact->save();
                    }
                    if ($i == 1){
                        $conceptFact = new DescripcionFactura();
                        $conceptFact->idfact = $queryFact[0]->idfact;
                        $conceptFact->descripcion = $request->get("concept_1");
                        $conceptFact->monto_unitario = $request->get("amountUnit_1");
                        $conceptFact->monto_bien = $request->get("amountService_1");
                        $conceptFact->save();
                    }
                }
            }
            if ($request->get('numconcept')==3){
                for ($i=0; $i < 3; $i++) { 
                    

                    if ($i == 0){
                        $conceptFact = new DescripcionFactura();
                        $conceptFact->idfact = $queryFact[0]->idfact;
                        $conceptFact->descripcion = $request->get("concept_0");
                        $conceptFact->monto_unitario = $request->get("amountUnit_0");
                        $conceptFact->monto_bien = $request->get("amountService_0");
                        $conceptFact->save();
                    }
                    if ($i == 1){
                        $conceptFact = new DescripcionFactura();
                        $conceptFact->idfact = $queryFact[0]->idfact;
                        $conceptFact->descripcion = $request->get("concept_1");
                        $conceptFact->monto_unitario = $request->get("amountUnit_1");
                        $conceptFact->monto_bien = $request->get("amountService_1");
                        $conceptFact->save();
                    }
                    if ($i == 2){
                        $conceptFact = new DescripcionFactura();
                        $conceptFact->idfact = $queryFact[0]->idfact;
                        $conceptFact->descripcion = $request->get("concept_2");
                        $conceptFact->monto_unitario = $request->get("amountUnit_2");
                        $conceptFact->monto_bien = $request->get("amountService_2");
                        $conceptFact->save();
                    }
                }
                $conceptFact->save();
            }
            if ($request->get('numconcept')==4){
                if ($i == 0){
                    $conceptFact = new DescripcionFactura();
                    $conceptFact->idfact = $queryFact[0]->idfact;
                    $conceptFact->descripcion = $request->get("concept_0");
                    $conceptFact->monto_unitario = $request->get("amountUnit_0");
                    $conceptFact->monto_bien = $request->get("amountService_0");
                    $conceptFact->save();
                }
                if ($i == 1){
                    $conceptFact = new DescripcionFactura();
                    $conceptFact->idfact = $queryFact[0]->idfact;
                    $conceptFact->descripcion = $request->get("concept_1");
                    $conceptFact->monto_unitario = $request->get("amountUnit_1");
                    $conceptFact->monto_bien = $request->get("amountService_1");
                    $conceptFact->save();
                }
                if ($i == 2){
                    $conceptFact = new DescripcionFactura();
                    $conceptFact->idfact = $request->$queryFact[0]->idfact;
                    $conceptFact->descripcion = $request->get("concept_2");
                    $conceptFact->monto_unitario = $request->get("amountUnit_2");
                    $conceptFact->monto_bien = $request->get("amountService_2");
                    $conceptFact->save();
                }
                if ($i == 3){
                    $conceptFact = new DescripcionFactura();
                    $conceptFact->idfact = $request->$queryFact[0]->idfact;
                    $conceptFact->descripcion = $request->get("concept_3");
                    $conceptFact->monto_unitario = $request->get("amountUnit_3");
                    $conceptFact->monto_bien = $request->get("amountService_3");
                    $conceptFact->save();
                }
                $conceptFact->save();
            }
            if ($request->get('numconcept')==5){
                if ($i == 0){
                    $conceptFact = new DescripcionFactura();
                    $conceptFact->idfact = $request->$queryFact[0]->idfact;
                    $conceptFact->descripcion = $request->get("concept_0");
                    $conceptFact->monto_unitario = $request->get("amountUnit_0");
                    $conceptFact->monto_bien = $request->get("amountService_0");
                    $conceptFact->save();
                }
                if ($i == 1){
                    $conceptFact = new DescripcionFactura();
                    $conceptFact->idfact = $request->$queryFact[0]->idfact;
                    $conceptFact->descripcion = $request->get("concept_1");
                    $conceptFact->monto_unitario = $request->get("amountUnit_1");
                    $conceptFact->monto_bien = $request->get("amountService_1");
                    $conceptFact->save();
                }
                if ($i == 2){
                    $conceptFact = new DescripcionFactura();
                    $conceptFact->idfact = $request->$queryFact[0]->idfact;
                    $conceptFact->descripcion = $request->get("concept_2");
                    $conceptFact->monto_unitario = $request->get("amountUnit_2");
                    $conceptFact->monto_bien = $request->get("amountService_2");
                    $conceptFact->save();
                }
                if ($i == 3){
                    $conceptFact = new DescripcionFactura();
                    $conceptFact->idfact = $request->$queryFact[0]->idfact;
                    $conceptFact->descripcion = $request->get("concept_3");
                    $conceptFact->monto_unitario = $request->get("amountUnit_3");
                    $conceptFact->monto_bien = $request->get("amountService_3");
                    $conceptFact->save();
                }
                if ($i == 4){
                    $conceptFact = new DescripcionFactura();
                    $conceptFact->idfact = $request->$queryFact[0]->idfact;
                    $conceptFact->descripcion = $request->get("concept_4");
                    $conceptFact->monto_unitario = $request->get("amountUnit_4");
                    $conceptFact->monto_bien = $request->get("amountService_4");
                    $conceptFact->save();
                }
                
            }
            return redirect()->route('totalinvoice',$idfact,$iddfact);
        }
    }

    public function totalinvoice($idfact,$iddfact){
        return view('invoice.totalinvoice');
    }
    
}