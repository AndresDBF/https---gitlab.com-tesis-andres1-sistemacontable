<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Models\ConceptoFact;
use App\Models\ContrCli;
use App\Models\TipPago;
use App\Models\Factura;
use App\Models\DetFact;
use App\Models\DescripcionFactura;
use App\Models\Moneda;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;


class FacturasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        $customer = Cliente::join('contr_clis','clientes.idcli','=','contr_clis.idcli')
        ->select('clientes.idcli','clientes.nombre','clientes.tipid','clientes.identificacion','clientes.tiprif','clientes.telefono', 
        'clientes.email','contr_clis.stscontr','contr_clis.tip_pag','contr_clis.moneda','contr_clis.montopaglocal','contr_clis.montopagmoneda')
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
        $invoice = Factura::join('det_facts', 'facturas.idfact', '=', 'det_facts.idfact')
                            ->where('facturas.idcli', $idcli)
                            ->select(
                                DB::raw('SUM(det_facts.mtototallocal) as sum_mtototallocal'),
                                DB::raw('SUM(det_facts.mtototalmoneda) as sum_mtototalmoneda')
                            )
                            ->first();   
                           
        $contrCli = ContrCli::where('idcli',$idcli)->first();
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
           $tippag = TipPago::where('tip_proceso','ingresos_gastos')
                            ->orderBy('descripcion')
                            ->get();
            $money = Moneda::all();
            $fecemi = Carbon::now()
                            ->format('Y-m-d');
        $customer = Cliente::where('idcli',$idcli)->first();
       
        if ($contrCli->montopaglocal > $invoice->sum_mtototallocal || $contrCli->montopagmoneda > $invoice->sum_mtototalmoneda) {
            return view('invoice/create',compact('idcli','numing','fecemi','tippag','numfact','numctrl','customer','money'));
        }
        else{
            Session::flash('error','monto total de giros superados para este cliente');
            return redirect()->route('findcustomer');
        }
    }

    public function storeinvoiceing(Request $request){
        $this->validate($request,[
            
            'numfact' => 'required',
            'numctrl' => 'required',
        ]);
        $idcli = intval($request->get('idcli'));
        $conceptFact = new ConceptoFact();
        $conceptFact->num_ing = $request->get('numreling');
        $conceptFact->num_egre = null;
        $conceptFact->save();

        $invoice = new Factura();
        $invoice->idcfact = $conceptFact->idcfact;
        $invoice->idcli = $idcli;
        $invoice->tip_pago = $request->get('tip_pag');
        $invoice->moneda = $request->get('money-select');
        $invoice->save();
        //insert in table det_fact

       
        $detInvoice = new DetFact();
        $detInvoice->idfact = $invoice->idfact;
        $detInvoice->numfact = $request->get('numfact');
        $detInvoice->numctrl = $request->get('numctrl');
        $detInvoice->stsfact = 'ACT';
        $detInvoice->fec_emi = $request->get('fecemi');
        $detInvoice->save();
        $numConcept = intval($request->get('numconcept'));
        $tasa_cambio = floatval($request->get('tasa_cambio'));
        return redirect()->route('createdetinvoiceing', ['numConcept' => $numConcept, 'idcli' => $idcli, 'tasa_cambio' => $tasa_cambio]);   
    }
    public function createdetinvoiceing($numConcept,$idcli,$tasa_cambio){
        $query = ConceptoFact::join('facturas','concepto_facts.idcfact','=','facturas.idcfact')
                            ->select ('concepto_facts.idcfact','concepto_facts.num_ing')
                            ->orderBy('concepto_facts.idcfact','desc')
                            ->take(1)
                            ->get();
        $cantConcept = $numConcept;
        $customer = Cliente::where('idcli',$idcli)->first();
        $invoice = Factura::orderBy('idfact','desc')
                          ->take(1)
                          ->get();
        $detInvoice = DetFact::orderBy('iddfact','desc')
                             ->take(1)
                             ->get();    
        $tippag = TipPago::where('tip_proceso','comprobante_ingreso')
                             ->orderBy('descripcion')
                             ->get();
        return view('invoice.detinvoice',compact('tippag','cantConcept','tasa_cambio','customer'))
                ->with('invoice',$invoice[0])
                ->with('query',$query[0])
                ->with('detInvoice',$detInvoice[0]);
                

    }

    public function storedetinvoiceing(Request $request){
        $numconcept = intval($request->get('numconcept'));
        $tasa_cambio = floatval($request->get('tasa_cambio'));
        $tipmoney = Factura::where('idfact',intval($request->get('idfact')))->first();
        $contrCli = ContrCli::select('montopaglocal','montopagmoneda')
                            ->where('idcli',intval($tipmoney->idcli))
                            ->first();
        if ($request->get('numconcept') == 1){
            
            $amountUnit = floatval($request->get('amountUnit_0'));
            $amountTotal = floatval($request->get('total-amount0'));
            
            $conceptFact = new DescripcionFactura();
            $conceptFact->idfact = $request->get('idfact');
            $conceptFact->descripcion = $request->get("concept_0");
            if ($tipmoney->moneda == 'EUR' || $tipmoney->moneda == 'USD') {
                if (floatval($request->get('total-amount0')) > floatval($contrCli->montopagmoneda)) {
                    Session::flash('more','el monto supera el total del contrato');
                    return redirect()->route('createdetinvoiceing',['numConcept' => $numconcept, 'idcli' => intval($tipmoney->idcli), 'tasa_cambio' => $tasa_cambio]);
                }
                $conceptFact->montounitariolocal = $amountUnit * $tasa_cambio;
                $conceptFact->monto_unitariomoneda = $amountUnit;
                $conceptFact->montobienlocal = $amountTotal * $tasa_cambio;
                $conceptFact->monto_bienmoneda = $amountTotal;
            }
            elseif ($tipmoney->moneda == 'COP') {
                if (floatval($request->get('total-amount0')) > floatval($contrCli->montopagmoneda)) {
                    Session::flash('more','el monto supera el total del contrato');
                    return redirect()->route('createdetinvoiceing',['numConcept' => $numconcept, 'idcli' => intval($tipmoney->idcli), 'tasa_cambio' => $tasa_cambio]);
                }
                $conceptFact->montounitariolocal = $amountUnit / $tasa_cambio;
                $conceptFact->monto_unitariomoneda = $amountUnit;
                $conceptFact->montobienlocal = $amountTotal / $tasa_cambio;
                $conceptFact->monto_bienmoneda = $amountTotal;
            }
            else{
                if (floatval($request->get('total-amount0')) > floatval($contrCli->montopaglocal)) {
                    Session::flash('more','el monto supera el total del contrato');
                    return redirect()->route('createdetinvoiceing',['numConcept' => $numconcept, 'idcli' => intval($tipmoney->idcli), 'tasa_cambio' => $tasa_cambio]);
                }
                $conceptFact->montounitariolocal = $amountUnit;
                $conceptFact->monto_unitariomoneda = 0;
                $conceptFact->montobienlocal = $amountTotal;
                $conceptFact->monto_bienmoneda = 0;
            }
            $conceptFact->save();
        }else{
            
            for ($i=0; $i < $numconcept; $i++) { 
                $amountUnit = floatval($request->get("amountUnit_" . $i));
                $amountTotal = floatval($request->get("total-amount" . $i));
                $conceptFact = new DescripcionFactura();
                $conceptFact->idfact = $request->get('idfact');
                $conceptFact->descripcion = $request->get("concept_" . $i);
                if ($tipmoney->moneda == 'EUR' || $tipmoney->moneda == 'USD') {
                    $conceptFact->montounitariolocal = $amountUnit * $tasa_cambio;
                    $conceptFact->monto_unitariomoneda = $amountUnit;
                    $conceptFact->montobienlocal = $amountTotal * $tasa_cambio;
                    $conceptFact->monto_bienmoneda = $amountTotal;
                }
                elseif ($tipmoney->moneda == 'COP') {
                    $conceptFact->montounitariolocal = $amountUnit / $tasa_cambio;
                    $conceptFact->monto_unitariomoneda = $amountUnit;
                    $conceptFact->montobienlocal = $amountTotal / $tasa_cambio;
                    $conceptFact->monto_bienmoneda = $amountTotal;
                }
                else{
                    $conceptFact->montounitariolocal = $amountUnit;
                    $conceptFact->monto_unitariomoneda = 0;
                    $conceptFact->montobienlocal = $amountTotal;
                    $conceptFact->monto_bienmoneda = 0;
                }
                
                $conceptFact->save();

            }
            $descripcionFactura = DescripcionFactura::where('idfact', $conceptFact->idfact)
                                                    ->selectRaw('SUM(monto_bienmoneda) as total_monto_bienmoneda, SUM(montobienlocal) as total_montobienlocal')
                                                    ->first();
            if (floatval($descripcionFactura->total_monto_bienmoneda > $contrCli->montopagmoneda)  ||  floatval($descripcionFactura->total_montobienlocal >$contrCli->montopaglocal)) {
                $descripcionFactura = DescripcionFactura::where('idfact', $conceptFact->idfact)->delete();
                Session::flash('more','el monto supera el total del contrato');
                return redirect()->route('createdetinvoiceing',['numConcept' => $numconcept, 'idcli' => intval($tipmoney->idcli), 'tasa_cambio' => $tasa_cambio]);
            }
        }
        $idfact = $conceptFact->idfact; 
            
        return redirect()->route('totalinvoice', ['idfact' => $idfact]);
        
    }

    public function totalinvoice($idfact) {
        $invoice = Factura::where('idfact',$idfact)->first();
       
        $detInvoice = DetFact::find($idfact);
        $idfact = intval($idfact);

        $baseImponibleLocal = DescripcionFactura::where('idfact', $idfact)->sum('montobienlocal');
        $baseImponiblemoneda = DescripcionFactura::where('idfact', $idfact)->sum('monto_bienmoneda');
        
        
        $descFact = DescripcionFactura::where('idfact', $idfact)->get();
        $detInvoice = DetFact::find($idfact);

        //$montoImpuesto = $montoImponible;
        $totalImpuestolocal = floatval($baseImponibleLocal * 0.16);
        $totalImpuestomoneda = floatval($baseImponiblemoneda * 0.16);
        $totalFactlocal = $baseImponibleLocal + $totalImpuestolocal;
        $totalFactmoneda = $baseImponiblemoneda + $totalImpuestomoneda;

        $customer = cliente::where('idcli',intval($invoice->idcli))->first();
        $idcli = intval($customer->idcli);
        DetFact::where('idfact',$idfact)->update([
            'mtolocal' => $baseImponibleLocal,
            'mtomoneda' => $baseImponiblemoneda,
            'mtoimponiblelocal' => $baseImponibleLocal,
            'mtoimponiblemoneda' => $baseImponiblemoneda,
            'mtoimpuestolocal' => $totalImpuestolocal,
            'mtoimpuestomoneda' => $totalImpuestomoneda,
            'mtototallocal' => $totalFactlocal,
            'mtototalmoneda' => $totalFactmoneda
        ]);
        /* $detInvoice->monto = $baseImponible;
        $detInvoice->mtoimponible = $baseImponible;
        $detInvoice->mtoimpuesto = $totalImpuesto;
        $detInvoice->mtototal = $totalFact;
        $detInvoice->save(); */
        return view('invoice.totalinvoice', compact('idcli','baseImponibleLocal',
        'baseImponiblemoneda','totalImpuestolocal','totalImpuestomoneda','totalFactlocal','totalFactmoneda',
        'invoice','descFact','idfact'));
    }

    public function convertToPdf($idfact,$idcli)
    {
        $customer = Cliente::find($idcli);

        $invoice = Factura::where('idfact',$idfact)
                        ->first();
        $detInvoice = DetFact::where('idfact',$idfact)
                            ->first();
        $descripInvoice = DescripcionFactura::where('idfact',$idfact)
                                            ->get(); 

        $numreling = ConceptoFact::join('facturas','concepto_facts.idcfact','=','facturas.idcfact')                        
                            ->select('concepto_facts.num_ing')
                            ->where('idfact',$idfact)
                            ->first();
        $imagePath = storage_path("img/logo.png");
      //  $image = "data:img/logo.png;base64,".base64_encode(file_get_contents($imagePath));     
        $image = base64_encode(file_get_contents($imagePath));
        

        $pdf = PDF::loadView('invoice.invoicepdf',compact('customer','invoice','detInvoice','descripInvoice','image','numreling'));
        
        return $pdf->download("giro_" . $customer->nombre . ".pdf");
        
        
        
         

    }
    
    public function deleteInvoice($idfact){
        $conceptInvoice = DescripcionFactura::where('idfact',$idfact)->delete();
        $detInvoice = DetFact::where('idfact',$idfact)->delete();
        $invoice = Factura::where('idfact',$idfact)->first();
        $idcli = Cliente::select('idcli')
                        ->where('idcli',intval($invoice->idcli))
                        ->first();
        $invoice = Factura::where('idfact',$idfact)->delete();
        $conceptFact = ConceptoFact::orderBy('created_at','desc')
                                    ->take(1)
                                    ->forceDelete();
        return redirect()->route('createinvoiceing',$idcli);
    }
    public function deletefact($idfact,$idcfact){
        $conceptInvoice = DescripcionFactura::where('idfact',$idfact)->delete();
        $detInvoice = DetFact::where('idfact',$idfact)->delete();
        $invoice = Factura::where('idfact',$idfact)->delete();
        $conceptFact = ConceptoFact::where('idcfact',$idcfact)->delete();
        return redirect()->route('findcustomer');
    }
    
}