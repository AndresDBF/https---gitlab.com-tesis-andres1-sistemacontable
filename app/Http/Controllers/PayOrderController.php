<?php

namespace App\Http\Controllers;

use App\Models\ConceptoGasto;
use Illuminate\Http\Request;
use App\Models\Proveedor;
use App\Models\OrdenCompra;
use App\Models\DetalleOrdenCompra;
use App\Models\DetalleOrdenPago;
use App\Models\TipPago;
use App\Models\Moneda;
use App\Models\OrdenPago;
use App\Models\ConceptoOrden;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class PayOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $registerPurchase = Proveedor::join('orden_compras','proveedors.idprov','=','orden_compras.idprov')
                                    ->select('orden_compras.idorco','proveedors.idprov','orden_compras.numorden','proveedors.nombre',
                                    'orden_compras.tiempo_pago','proveedors.direccion')
                                    ->where('orden_compras.stsorden','AUT')
                                    ->orderBy('proveedors.nombre','asc')
                                    ->get();
        
        
        return view('payorder.index',compact('registerPurchase'));
    }

    public function createpayorder($idprov, $idorco){
        $numegre = rand(100000,999999);
        $supplier = Proveedor::find($idprov);
        $fecEmi = Carbon::now()->format('d/m/y');
        $tippag = TipPago::where('tip_proceso','comprobante_ingreso')
                            ->orderBy('descripcion')
                            ->get();
        $money = Moneda::all();
        

        return view('payorder.create',compact('numegre','supplier','fecEmi','tippag','money','idprov','idorco'));
    }

    public function store(Request $request){
        $this->validate($request,[
            'numfact' => 'required|numeric',
           // 'numctrl' => 'required|regex:/^\d{2}-\d{3}$/',
            'name' => 'required|regex:/^[A-Z][A-Z,a-z, ,á,é,í,ó,ú]+$/',
            'direction'=>'required',
            'tipid' => 'required',
            'identification' => 'required|numeric',
            'phone' => 'required',
            
        ]);
         

        $idprov = $request->get('idprov');
        $idorco = $request->get('idorco');
        $tasa_cambio = $request->get('tasa_cambio');
        if ($tasa_cambio == null && ($request->get('money') != 'BS')) {
            Session::flash('error','debe seleccionar una tasa de cambio');
            return redirect()->route('createpayorder',['idprov' => $idprov, 'idorco' => $idorco]);
        }
        else{
            $idorco = $request->get('idorco');
            $idprov = $request->get('idprov');
            $purchase = OrdenCompra::where('idorco',$idorco)->first();

            //para sumar a la fecha de vencimiento de la factura
            $fecemi = $request->get('fecemi');
            $newFecemi = Carbon::createFromFormat('d/m/y',$fecemi);
            $value = intval($purchase->tiempo_pago);
            $fecven = $newFecemi->addDays($value);
        
            $newFecven = $fecven->format('d/m/y');




            $payOrder = new OrdenPago();
            $payOrder->idorco = $request->get('idorco');
            $payOrder->idprov = $request->get('idprov');
            $payOrder->num_egre = $request->get('numrelegre');
            $payOrder->stsorpa = 'ACT';
            $payOrder->numfact = $request->get('numfact');
            $payOrder->numctrl = $request->get('numctrl');
            $payOrder->fec_emi = $fecemi;
            $payOrder->fec_vencimiento = $newFecven;
            if($request->get('tip_pag') == 'Selecciona un tipo de pago'){
                
                Session::flash('errorpag','debe seleccionar un tipo de pago');
                return redirect()->route('createpayorder',['idprov' => $idprov,'idorco' => $idorco]);
            }else{
                $payOrder->tippago = $request->get('tip_pag');
            }

            if($request->get('money') == 'Selecciona un tipo de moneda'){
                
                Session::flash('errormon','debe seleccionar un tipo de moneda');
                return redirect()->route('createpayorder',['idprov' => $idprov,'idorco' => $idorco]);
            }else{
                $payOrder->moneda = $request->get('money');
            }


            $payOrder->save();
            $numConcept = $request->get('numconcept');
            OrdenCompra::where('idorco', $request->get('idorco'))->update([
                'stsorden' => 'INC'
            
            ]);

        }
        
        
        return redirect()->route('detorder',['numConcept' => $numConcept, 'tasa' => $tasa_cambio]);

    }

    public function detorder($numConcept,$tasa){
        $payOrder = OrdenPago::orderBy('idorpa','desc')
                            ->take(1)
                            ->get();
        $idprov = $payOrder->pluck('idprov')->values()->first();
        $idorco = $payOrder->pluck('idorco')->values()->first();
        $tippag = $payOrder->pluck('tippago')->values()->first();
        $money  = $payOrder->pluck('moneda')->values()->first();
        $idorpa = $payOrder->pluck('idorpa')->values()->first();
        $supplier = Proveedor::where('idprov',$idprov)
                            ->first();
        $pay = TipPago::where('tippago',$tippag)->first();
        $tipmon = Moneda::where('tipmoneda',$money)->get();
        //dd($pay);
        return view('payorder.detorder',compact('supplier','pay','tipmon','numConcept','idprov','idorco','idorpa','tasa'))
                ->with('payOrder',$payOrder[0])
                ->with('pay',$pay)
                ->with('tipmon',$tipmon[0]);//seguir aqui
    }

    public function storedetorder(Request $request){
        $tasa_cambio = floatval($request->get('tasa'));
        $numConcept = intval($request->get('numconcept'));
        $taxes = 0;
        $amountTot = 0;
        $totOrder = 0;
        if ($numConcept == 1) {
            $amountUnit = floatval($request->get('amountUnit_0'));
            $amountTot = floatval($request->get('total-amount0'));
            $conceptOrder = new ConceptoOrden();
            $conceptOrder->idorpa = $request->get('idorpa');
            $conceptOrder->descripcion = $request->get("concept_0");
            if ($request->get('money') == 'BS'){
                $conceptOrder->montounitariolocal = $amountUnit;
                $conceptOrder->montounitariomoneda = 0;
                $conceptOrder->montobienlocal = $amountTot;
                $conceptOrder->montobienmoneda = 0;
                $conceptOrder->save();
            }
            elseif ($request->get('money') == 'USD' || $request->get('money') == 'EUR') {
                $conceptOrder->montounitariolocal =  $amountUnit * $tasa_cambio;
                $conceptOrder->montounitariomoneda = $amountUnit;
                $conceptOrder->montobienlocal = $amountTot * $tasa_cambio;
                $conceptOrder->montobienmoneda = $amountTot;
                $conceptOrder->save();
            }
            else {
                $conceptOrder->montounitariolocal = $amountUnit / $tasa_cambio;
                $conceptOrder->montounitariomoneda = 
                $conceptOrder->montobienlocal = $amountTot;
                $conceptOrder->montobienmoneda = $amountTot / $tasa_cambio;
                $conceptOrder->save();
            }
            

            $taxeslocal =  $conceptOrder->montobienlocal * 0.16;
            $taxesmoneda =  $conceptOrder->montobienmoneda * 0.16;

            $amountTotlocal = $taxeslocal + $conceptOrder->montobienlocal;
            $amountTotmoneda = $taxesmoneda + $conceptOrder->montobienmoneda;

            $igtflocal = $amountTotlocal * 0.03;
            $igtfmoneda = $amountTotmoneda * 0.03;
            $totpayorderlocal = $amountTotlocal + $igtflocal;
            $totpayordermoneda = $amountTotmoneda + $igtfmoneda;

            $detOrder = new DetalleOrdenPago();
            $detOrder->idorpa = $request->get('idorpa');
            $detOrder->idcon = $conceptOrder->idcon;
            $detOrder->baseimponiblelocal = $conceptOrder->montobienlocal;
            $detOrder->baseimponiblemoneda = $conceptOrder->montobienmoneda;
            $detOrder->montoivalocal = $taxeslocal;
            $detOrder->montoivamoneda = $taxesmoneda;
            $detOrder->montototallocal = $totpayorderlocal;
            $detOrder->montototalmoneda = $totpayordermoneda;
            $detOrder->tasa_cambio = $tasa_cambio;
            $detOrder->save();
            $idorpa = $detOrder->idorpa;
            /* $sumAmount = ConceptoOrden::where('idorpa',$idorpa)
                                            ->sum('monto_bien');
            $taxes =  floatval($sumAmount * 0.16);
            $totOrder = floatval($sumAmount + $taxes);   
            DetalleOrdenPago::where('idorpa', $idorpa)->update([
                'monto_iva' => $taxes,
                'monto_total' => $totOrder
            ]); */
        }
        else {
            for ($i=0; $i < $numConcept; $i++) { 
                $amountUnit = floatval($request->get("amountUnit_" . $i));
                $amountTot = floatval($request->get("total-amount" . $i));
                $conceptOrder = new ConceptoOrden();
                $conceptOrder->idorpa = $request->get('idorpa');
                $conceptOrder->descripcion = $request->get("concept_" . $i);
                if ($request->get('money') == 'BS'){
                    $conceptOrder->montounitariolocal = $amountUnit;
                    $conceptOrder->montounitariomoneda = 0;
                    $conceptOrder->montobienlocal = $amountTot;
                    $conceptOrder->montobienmoneda = 0;
                    $conceptOrder->save();
                }
                elseif ($request->get('money') == 'USD' || $request->get('money') == 'EUR') {
                    $conceptOrder->montounitariolocal =  $amountUnit * $tasa_cambio;
                    $conceptOrder->montounitariomoneda = $amountUnit;
                    $conceptOrder->montobienlocal = $amountTot * $tasa_cambio;
                    $conceptOrder->montobienmoneda = $amountTot;
                    $conceptOrder->save();
                }
                else {
                    $conceptOrder->montounitariolocal = $amountUnit / $tasa_cambio;
                    $conceptOrder->montounitariomoneda = 
                    $conceptOrder->montobienlocal = $amountTot;
                    $conceptOrder->montobienmoneda = $amountTot / $tasa_cambio;
                    $conceptOrder->save();
                }
                
    
                $taxeslocal =  $conceptOrder->montobienlocal * 0.16;
                $taxesmoneda =  $conceptOrder->montobienmoneda * 0.16;
    
                $amountTotlocal = $taxeslocal + $conceptOrder->montobienlocal;
                $amountTotmoneda = $taxesmoneda + $conceptOrder->montobienmoneda;
    
                $igtflocal = $amountTotlocal * 0.03;
                $igtfmoneda = $amountTotmoneda * 0.03;
                $totpayorderlocal = $amountTotlocal + $igtflocal;
                $totpayordermoneda = $amountTotmoneda + $igtfmoneda;
    
                $detOrder = new DetalleOrdenPago();
                $detOrder->idorpa = $request->get('idorpa');
                $detOrder->idcon = $conceptOrder->idcon;
                $detOrder->baseimponiblelocal = $conceptOrder->montobienlocal;
                $detOrder->baseimponiblemoneda = $conceptOrder->montobienmoneda;
                $detOrder->montoivalocal = $taxeslocal;
                $detOrder->montoivamoneda = $taxesmoneda;
                $detOrder->montototallocal = $totpayorderlocal;
                $detOrder->montototalmoneda = $totpayordermoneda;
                $detOrder->save();
                $idorpa = $detOrder->idorpa;
            }
        }
        
        return redirect()->route('totalorderpa', ['idorpa' => $idorpa]);
    }

    public function totalorder($idorpa){
        $valueIdorpa = intval($idorpa);
        $amountOrder = ConceptoOrden::where('idorpa',$idorpa)
                                            ->get();
        $detailOrder = DetalleOrdenPago::where('idorpa',$idorpa)->first();    
        $payOrder = OrdenPago::where('idorpa',$idorpa)->first();    

        return view('payorder.total',['amountOrder' => $amountOrder],compact('detailOrder','idorpa','payOrder'));
    }

    public function deleteorderpa($idprov,$idorco){
       $payOrder = OrdenPago::where('idorco',$idorco)->delete();
       return redirect()->route('create',['idprov' => $idprov, 'idorco' => $idorco]);
    }

    public function deletedetorderpa($idorpa){
        $detailorder = DetalleOrdenPago::where('idorpa',$idorpa)->delete();
        $conceptpayorder = ConceptoOrden::where('idorpa',$idorpa)->delete();

        $payorder = OrdenPago::where('idorpa',$idorpa)->delete();
        return redirect()->route('registerorder');
    }

}
