<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
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
    public function index(){
        $customer = Cliente::join('contr_clis','clientes.idcli','=','contr_clis.idcli')
        ->select('contr_clis.idasi','clientes.idcli','clientes.nombre','clientes.identificacion','clientes.telefono',
        'clientes.email','contr_clis.stscontr','contr_clis.tip_pag')
        ->orderBy('clientes.nombre')
        ->paginate(10);
        
        return view('invoice.index')
             ->with('customer',$customer);

    }
    public function createinvoiceing($idcli){
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
           $tippag = TipPago::where('tip_proceso','comprobante_ingreso')
                            ->orderBy('descripcion')
                            ->get();
            $fecemi = Carbon::now()
                            ->format('d/m/y');
        $customer = Cliente::where('idcli',$idcli)->first();
        return view('invoice/create',compact('numing','fecemi','tippag','numfact','numctrl','customer'));
              /*->with('numing',$conceptoFact->idcfact)
                ->with('fecemi',$fecemi)
                ->with('tippag',$tippag); */
    }

    public function storeinvoiceing(Request $request){

        $this->validate($request,[
            
            'numfact' => 'required',
            'numctrl' => 'required',
        ]);
       
         $conceptFact = new ConceptoFact();
        $conceptFact->num_ing = $request->get('numreling');
        $conceptFact->num_egre = null;
        $conceptFact->save();

        $invoice = new Factura();
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
        $detInvoice->idfact = $invoice->idfact;
        $detInvoice->numfact = $request->get('numfact');
        $detInvoice->numctrl = $request->get('numctrl');
        $detInvoice->stsfact = 'ACT';
        $detInvoice->fec_emi = $request->get('fecemi');
        $detInvoice->save();
        $numConcept = $request->get('numconcept');
        return redirect()->route('createdetinvoiceing',$numConcept);
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
        $tippag = TipPago::where('tip_proceso','comprobante_ingreso')
                             ->orderBy('descripcion')
                             ->get();
        return view('invoice.detinvoice',compact('tippag','cantConcept'))
                ->with('invoice',$invoice[0])
                ->with('query',$query[0])
                ->with('detInvoice',$detInvoice[0]);
                

    }

    public function storedetinvoiceing(Request $request){
        $numconcept = intval($request->get('numconcept'));
        
        
        if ($request->get('numconcept') == 1){
            $conceptFact = new DescripcionFactura();
            $conceptFact->idfact = $request->get('idfact');
            $conceptFact->descripcion = $request->get("concept_0");
            $conceptFact->monto_unitario = $request->get("amountUnit_0");
            $conceptFact->monto_bien = $request->get("total-amount0");
            $conceptFact->save();
        }else{
            for ($i=0; $i < $numconcept; $i++) { 
                $conceptFact = new DescripcionFactura();
                $conceptFact->idfact = $request->get('idfact');
                $conceptFact->descripcion = $request->get("concept_" . $i);
                $conceptFact->monto_unitario = $request->get("amountUnit_" . $i);
                $conceptFact->monto_bien = $request->get("total-amount" . $i);
                $conceptFact->save();
            }
        }
        $idfact = $conceptFact->idfact; 
            
        return redirect()->route('totalinvoice', ['idfact' => $idfact]);
        
    }

    public function totalinvoice($idfact) {
        $detInvoice = DetFact::find($idfact);
        $idfact = intval($idfact);

        $baseImponible = DescripcionFactura::where('idfact', $idfact)->sum('monto_bien');
        
        $descFact = DescripcionFactura::where('idfact', $idfact)->get();
        $detInvoice = DetFact::find($idfact);

        //$montoImpuesto = $montoImponible;
        $totalImpuesto = floatval($baseImponible * 0.16);
        $totalFact = $baseImponible + $totalImpuesto;
        DetFact::where('idfact',$idfact)->update([
            'monto' => $baseImponible,
            'mtoimponible' => $baseImponible,
            'mtoimpuesto' => $totalImpuesto,
            'mtototal' => $totalFact
        ]);
        /* $detInvoice->monto = $baseImponible;
        $detInvoice->mtoimponible = $baseImponible;
        $detInvoice->mtoimpuesto = $totalImpuesto;
        $detInvoice->mtototal = $totalFact;
        $detInvoice->save(); */
        return view('invoice.totalinvoice', ['totalFact' => $totalFact],compact('baseImponible','totalImpuesto','descFact','idfact'));
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
    public function deletefact($idfact){
        $conceptInvoice = DescripcionFactura::where('idfact',$idfact)->delete();
        $detInvoice = DetFact::where('idfact',$idfact)->delete();
        $invoice = Factura::where('idfact',$idfact)->delete();
        return redirect()->route('findcustomer');
    }
    
}