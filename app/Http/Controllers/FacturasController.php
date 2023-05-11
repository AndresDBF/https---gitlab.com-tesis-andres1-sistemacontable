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
        $query = ConceptoFact::orderBy('idcfact','desc')
                               ->take(1)
                               ->get();
        $queryFact = DetFact::orderBy('iddfact','desc')
                            ->take(1)
                            ->get();       
        //cambiar por una variable local                    
            $values = count($query);
            if ($values == 0){
                $numing = rand(100000,999999);
                $numfact = 1;
                $numctrl = 1;
               
            }
            else{
                $numing = rand(100000,999999);
                $numfact = intval(substr($queryFact[0]->numfact,-1))+1;
                $numctrl = intval(substr($queryFact[0]->numctrl,-1))+1;
                
                
            }
           // $numing = $conceptoFact->idcfact;
           $tippag = TipPago::where('tip_proceso','contr_cli')
                            ->orderBy('descripcion')
                            ->get();
            $fecemi = Carbon::now()
                            ->format('d/m/y');

        return view('invoice/create',compact('numing','fecemi','tippag','numfact','numctrl'));
              /*->with('numing',$conceptoFact->idcfact)
                ->with('fecemi',$fecemi)
                ->with('tippag',$tippag); */
    }

    public function storeinvoiceing(Request $request){

        $this->validate($request,[
            
            'name' => 'required|regex:/^[A-Z][A-Z,a-z, ,á,é,í,ó,ú]+$/',
            'tipid' => 'required',
            'identification' => 'required|numeric',
            'phone' => 'required',
            'direction'=>'required',             
            'tip_pag' => 'required',
            'numconcept' => 'required'
        ]);
        
       $query = Factura::orderBy('idfact','desc')
                        ->take(1)
                        ->get();
        $values = count($query);
            if ($values == 0){
                $idfact = 1;

                $conceptFact = new ConceptoFact();
                $conceptFact->idcfact = 1;
                $conceptFact->num_ing = $request->get('numreling');
                $conceptFact->num_egre = null;
                $conceptFact->save();

                $invoice = new Factura();
                $invoice->idfact = $idfact;
                $invoice->idcfact = $conceptFact->idcfact;
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
                $detInvoice->idfact = $invoice->idfact;
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

                $conceptFact = new ConceptoFact();
                $idfact = $query[0]->idfact+1;
                $conceptFact->num_ing = $request->get('numreling');
                $conceptFact->num_egre = null;
                $conceptFact->save();

                $invoice = new Factura();
                $invoice->idfact = $idfact;
                $invoice->idcfact = $conceptFact->idcfact;
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
                $detInvoice->idfact = $invoice->idcfact;
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
        $query = ConceptoFact::join('facturas','concepto_facts.idcfact','=','facturas.idcfact')
                            ->select ('concepto_facts.idcfact','concepto_facts.num_ing')
                            ->orderBy('concepto_facts.idcfact','desc')
                            ->take(1)
                            ->get();
        $cantConcept = $numConcept;
       
        
        $invoice = Factura::orderBy('idfact','desc')
                          ->take(1)
                          ->get();
        
        $detInvoice = DetFact::orderBy('iddfact','desc')
                             ->take(1)
                             ->get();    
        $tippag = TipPago::where('tip_proceso','contr_cli')
                             ->orderBy('descripcion')
                             ->get();
        return view('invoice.detinvoice',compact('tippag','cantConcept'))
                ->with('invoice',$invoice[0])
                ->with('query',$query[0])
                ->with('detInvoice',$detInvoice[0]);
                

    }

    public function storedetinvoiceing(Request $request){
       
        $numconcept = intval($request->get('numconcept'));
        
        $query = DescripcionFactura::orderBy('iddfact','desc')
                                    ->take(1)
                                    ->get();  
        
        
        
        $queryFact = Factura::orderBy('idfact','desc')
                            ->take(1)
                            ->get();
        
        $values = count($query);
        
        if ($values == 0){
            $iddfact = 1;
            //condition for number conceptFact
           /*  foreach ($request->get('numconcept') as $concept ) {
                $conceptFact = new DescripcionFactura();
                $conceptFact->idfact = $request->get('numreling');
                $conceptFact->descripcion = $request->get("concept_");
                $conceptFact->monto_unitario = $request->get("amountUnit_0");
                $conceptFact->monto_bien = $request->get("amountService_0");
                if($request->get('numconcept') == 2){
                    $conceptFact->monto_unitario = $request->get("amountUnit_1");
                    $conceptFact->monto_bien = $request->get("amountService_1");
                }
                $conceptFact->save();
            } */
            if ($request->get('numconcept')==1){
                $conceptFact = new DescripcionFactura();
                $conceptFact->iddfact =  $iddfact;
                $conceptFact->idfact = $queryFact[0]->idfact;
                $conceptFact->descripcion = $request->get("concept_0");
                $conceptFact->monto_unitario = $request->get("amountUnit_0");
                $conceptFact->monto_bien = $request->get("total-amount0");
                $conceptFact->save();
            }
            if ($request->get('numconcept')==2){
                for ($i=0; $i <= 1 ; $i++) { 
                    if ($i == 0){

                        $conceptFact = new DescripcionFactura();
                        $conceptFact->iddfact = $iddfact;
                        
                        $conceptFact->idfact = $queryFact[0]->idfact;
                        $conceptFact->descripcion = $request->get("concept_0");
                        $conceptFact->monto_unitario = $request->get("amountUnit_0");
                        $conceptFact->monto_bien = $request->get("total-amount0");
                        $conceptFact->save();
                    }
                    if ($i == 1){
                        $conceptFact = new DescripcionFactura();
                        $conceptFact->iddfact = $iddfact+1;
                        $conceptFact->idfact = $queryFact[0]->idfact;
                        $conceptFact->descripcion = $request->get("concept_1");
                        $conceptFact->monto_unitario = $request->get("amountUnit_1");
                        $conceptFact->monto_bien = $request->get("total-amount0");
                        $conceptFact->save();
                    }
                }     
            } 
            if ($request->get('numconcept')==3){
                for ($i=0; $i < 3; $i++) { 
                    if ($i == 0){
                        $conceptFact = new DescripcionFactura();
                        $conceptFact->iddfact = $iddfact;
                        $conceptFact->idfact = $queryFact[0]->idfact;
                        $conceptFact->descripcion = $request->get("concept_0");
                        $conceptFact->monto_unitario = $request->get("amountUnit_0");
                        $conceptFact->monto_bien = $request->get("total-amount0");
                        $conceptFact->save();
                    }
                    if ($i == 1){
                        $conceptFact = new DescripcionFactura();
                        $conceptFact->iddfact = $iddfact+1;
                        $conceptFact->idfact = $queryFact[0]->idfact;
                        $conceptFact->descripcion = $request->get("concept_1");
                        $conceptFact->monto_unitario = $request->get("amountUnit_1");
                        $conceptFact->monto_bien = $request->get("total-amount1");
                        $conceptFact->save();
                    }
                    if ($i == 2){
                        $conceptFact = new DescripcionFactura();
                        $conceptFact->iddfact = $iddfact+1;
                        $conceptFact->idfact = $queryFact[0]->idfact;
                        $conceptFact->descripcion = $request->get("concept_2");
                        $conceptFact->monto_unitario = $request->get("amountUnit_2");
                        $conceptFact->monto_bien = $request->get("total-amount2");
                        $conceptFact->save();
                    }
                }
            }
            if ($request->get('numconcept')==4){
                for ($i=0; $i < 3; $i++) { 
                    if ($i == 0){
                        $conceptFact = new DescripcionFactura();
                        $conceptFact->iddfact = $iddfact;
                        $conceptFact->idfact = $queryFact[0]->idfact;
                        $conceptFact->descripcion = $request->get("concept_0");
                        $conceptFact->monto_unitario = $request->get("amountUnit_0");
                        $conceptFact->monto_bien = $request->get("total-amount0");
                        $conceptFact->save();
                    }
                    if ($i == 1){
                        $conceptFact = new DescripcionFactura();
                        $conceptFact->iddfact = $iddfact+1;
                        $conceptFact->idfact = $queryFact[0]->idfact;
                        $conceptFact->descripcion = $request->get("concept_1");
                        $conceptFact->monto_unitario = $request->get("amountUnit_1");
                        $conceptFact->monto_bien = $request->get("total-amount1");
                        $conceptFact->save();
                    }
                    if ($i == 2){
                        $conceptFact = new DescripcionFactura();
                        $conceptFact->iddfact = $iddfact+1;
                        $conceptFact->idfact = $queryFact[0]->idfact;
                        $conceptFact->descripcion = $request->get("concept_2");
                        $conceptFact->monto_unitario = $request->get("amountUnit_2");
                        $conceptFact->monto_bien = $request->get("total-amount2");
                        $conceptFact->save();
                    }
                    if ($i == 3){
                        $conceptFact = new DescripcionFactura();
                        $conceptFact->iddfact = $iddfact+1;
                        $conceptFact->idfact = $queryFact[0]->idfact;
                        $conceptFact->descripcion = $request->get("concept_3");
                        $conceptFact->monto_unitario = $request->get("amountUnit_3");
                        $conceptFact->monto_bien = $request->get("total-amount3");
                        $conceptFact->save();
                    }
                }
                
            }
            if ($request->get('numconcept')==5){
                
                if ($i == 0){
                    $conceptFact = new DescripcionFactura();
                    $conceptFact->iddfact = $iddfact;
                    $conceptFact->idfact = $queryFact[0]->idfact;
                    $conceptFact->descripcion = $request->get("concept_0");
                    $conceptFact->monto_unitario = $request->get("amountUnit_0");
                    $conceptFact->monto_bien = $request->get("amountService_0");
                    $conceptFact->save();
                }
                if ($i == 1){
                    $conceptFact = new DescripcionFactura();
                    $conceptFact->iddfact = $iddfact+1;
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
                if ($i == 3){
                    $conceptFact = new DescripcionFactura();
                    $conceptFact->iddfact = $iddfact+1;
                    $conceptFact->idfact = $queryFact[0]->idfact;
                    $conceptFact->descripcion = $request->get("concept_3");
                    $conceptFact->monto_unitario = $request->get("amountUnit_3");
                    $conceptFact->monto_bien = $request->get("amountService_3");
                    $conceptFact->save();
                }
                if ($i == 4){
                    $conceptFact = new DescripcionFactura();
                    $conceptFact->iddfact = $iddfact+1;
                    $conceptFact->idfact = $queryFact[0]->idfact;
                    $conceptFact->descripcion = $request->get("concept_4");
                    $conceptFact->monto_unitario = $request->get("amountUnit_4");
                    $conceptFact->monto_bien = $request->get("amountService_4");
                    $conceptFact->save();
                }
               
            }      
            $idfact = $conceptFact->idfact;
            
            return redirect()->route('totalinvoice', ['idfact' => $idfact, 'numconcept' => $numconcept]);
        
        }
        else{
            $iddfact = $query[0]->iddfact+1;
            
            //condition for number conceptFact
            if ($request->get('numconcept')==1){
                $conceptFact = new DescripcionFactura();
                $conceptFact->iddfact = $iddfact;
                $conceptFact->idfact = $queryFact[0]->idfact;
                $conceptFact->descripcion = $request->get("concept_0");
                $conceptFact->monto_unitario = $request->get("amountUnit_0");
                $conceptFact->monto_bien = $request->get("total-amount0");
                $conceptFact->save();
            }
            if ($request->get('numconcept')==2){
                for ($i=0; $i < 2 ; $i++){ 
                    if ($i == 0){
                        $conceptFact = new DescripcionFactura();
                        $conceptFact->iddfact = $iddfact;
                        $conceptFact->idfact = $queryFact[0]->idfact;
                        $conceptFact->descripcion = $request->get("concept_0");
                        $conceptFact->monto_unitario = $request->get("amountUnit_0");
                        $conceptFact->monto_bien = $request->get("total-amount0");
                        $conceptFact->save();
                    }
                    if ($i == 1){
                        $conceptFact = new DescripcionFactura();
                        $conceptFact->iddfact = $iddfact+1;
                        $conceptFact->idfact = $queryFact[0]->idfact;
                        $conceptFact->descripcion = $request->get("concept_1");
                        $conceptFact->monto_unitario = $request->get("amountUnit_1");
                        $conceptFact->monto_bien = $request->get("total-amount1");
                        $conceptFact->save();
                    }
                }
            }
            if ($request->get('numconcept')==3){
                for ($i=0; $i < 3; $i++) { 
                    

                    if ($i == 0){
                        $conceptFact = new DescripcionFactura();
                        $conceptFact->iddfact = $iddfact;
                        $conceptFact->idfact = $queryFact[0]->idfact;
                        $conceptFact->descripcion = $request->get("concept_0");
                        $conceptFact->monto_unitario = $request->get("amountUnit_0");
                        $conceptFact->monto_bien = $request->get("amountService_0");
                        $conceptFact->save();
                    }
                    if ($i == 1){
                        $conceptFact = new DescripcionFactura();
                        $conceptFact->iddfact = $iddfact+1;
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
                $conceptFact->save();
            }
            if ($request->get('numconcept')==4){
                for ($i=0; $i < 1; $i++) { 
                    if ($i == 0){
                        $conceptFact = new DescripcionFactura();
                        $conceptFact->iddfact = $iddfact;
                        $conceptFact->idfact = $queryFact[0]->idfact;
                        $conceptFact->descripcion = $request->get("concept_0");
                        $conceptFact->monto_unitario = $request->get("amountUnit_0");
                        $conceptFact->monto_bien = $request->get("total-amount0");
                        $conceptFact->save();
                    }
                    if ($i == 1){
                        $conceptFact = new DescripcionFactura();
                        $conceptFact->iddfact = $iddfact+1;
                        $conceptFact->idfact = $queryFact[0]->idfact;
                        $conceptFact->descripcion = $request->get("concept_1");
                        $conceptFact->monto_unitario = $request->get("amountUnit_1");
                        $conceptFact->monto_bien = $request->get("total-amount1");
                        $conceptFact->save();
                    }
                    if ($i == 2){
                        $conceptFact = new DescripcionFactura();
                        $conceptFact->iddfact = $iddfact+1;
                        $conceptFact->idfact = $queryFact[0]->idfact;
                        $conceptFact->descripcion = $request->get("concept_2");
                        $conceptFact->monto_unitario = $request->get("amountUnit_2");
                        $conceptFact->monto_bien = $request->get("total-amount2");
                        $conceptFact->save();
                    }
                    if ($i == 3){
                        $conceptFact = new DescripcionFactura();
                        $conceptFact->iddfact = $iddfact+1;
                        $conceptFact->idfact = $queryFact[0]->idfact;
                        $conceptFact->descripcion = $request->get("concept_3");
                        $conceptFact->monto_unitario = $request->get("amountUnit_3");
                        $conceptFact->monto_bien = $request->get("total-amount3");
                        $conceptFact->save();
                    } 
                }
            }
            if ($request->get('numconcept')==5){
                if ($i == 0){
                    $conceptFact = new DescripcionFactura();
                    $conceptFact->iddfact = $iddfact;
                    $conceptFact->idfact = $queryFact[0]->idfact;
                    $conceptFact->descripcion = $request->get("concept_0");
                    $conceptFact->monto_unitario = $request->get("amountUnit_0");
                    $conceptFact->monto_bien = $request->get("amountService_0");
                    $conceptFact->save();
                }
                if ($i == 1){
                    $conceptFact = new DescripcionFactura();
                    $conceptFact->iddfact = $iddfact+1;
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
                if ($i == 3){
                    $conceptFact = new DescripcionFactura();
                    $conceptFact->iddfact = $iddfact+1;
                    $conceptFact->idfact = $queryFact[0]->idfact;
                    $conceptFact->descripcion = $request->get("concept_3");
                    $conceptFact->monto_unitario = $request->get("amountUnit_3");
                    $conceptFact->monto_bien = $request->get("amountService_3");
                    $conceptFact->save();
                }
                if ($i == 4){
                    $conceptFact = new DescripcionFactura();
                    $conceptFact->iddfact = $iddfact+1;
                    $conceptFact->idfact = $queryFact[0]->idfact;
                    $conceptFact->descripcion = $request->get("concept_4");
                    $conceptFact->monto_unitario = $request->get("amountUnit_4");
                    $conceptFact->monto_bien = $request->get("amountService_4");
                    $conceptFact->save();
                }
                
            }
            $idfact = $conceptFact->idfact;
            
            return redirect()->route('totalinvoice', ['idfact' => $idfact]);
        }
    }

    public function totalinvoice($idfact) {
        $detInvoice = DetFact::find($idfact);
        $detInvoice->monto = null;
        $detInvoice->mtoimponible = null;
        $detInvoice->mtoimpuesto = null;
        $detInvoice->mtototal = null;
        $detInvoice->save();
        $idfact = intval($idfact);
        $montoImponible = 0;
        $montoImpuesto = 0;

        $totalFact = DescripcionFactura::where('idfact', $idfact)->get();
        $detInvoice = DetFact::find($idfact);

        foreach ($totalFact as $detalle) {
            $montoImponible += $detalle->monto_bien;
        } 

        //$montoImpuesto = $montoImponible;
        $totalFactura = floatval($montoImponible + $montoImpuesto);
        
        $detInvoice->monto = $montoImponible;
        $detInvoice->mtoimponible = $montoImponible;
        $detInvoice->mtoimpuesto = $montoImpuesto;
        $detInvoice->mtototal = $totalFactura;
        $detInvoice->save();
        return view('invoice.totalinvoice', ['totalFact' => $totalFact],compact('montoImponible','montoImpuesto','totalFactura','idfact'));
    }
    
    public function deleteInvoice($idfact){
        $conceptInvoice = DescripcionFactura::where('idfact',$idfact)->delete();
        $detInvoice = DetFact::where('idfact',$idfact)->delete();
        $invoice = Factura::where('idfact',$idfact)->delete();
        $conceptFact = ConceptoFact::orderBy('created_at','desc')
                                    ->take(1)
                                    ->forceDelete();
        return redirect()->route('createinvoiceing');
    }
    
}