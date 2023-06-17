<?php

namespace App\Http\Controllers;

use App\Models\CategoriaProveedor;
use Illuminate\Http\Request;
use App\Models\Proveedor;
use App\Models\OrdenCompra;
use App\Models\DetalleOrdenCompra;
use App\Models\Moneda;
use App\Models\TipPago;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;


class PurchaseOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function reportorder(){
        $registerPurchase = Proveedor::join('orden_compras','proveedors.idprov','=','orden_compras.idprov')
                                     ->select('orden_compras.idorco','orden_compras.numorden','proveedors.nombre','proveedors.identificacion',
                                     'orden_compras.stsorden','orden_compras.tiempo_pago','proveedors.tipid','proveedors.tiprif')
                                     ->where('orden_compras.stsorden','ACT')
                                     ->orderBy('proveedors.nombre','asc')
                                     ->get();
   
        return view('purchase.index',compact('registerPurchase'));
    }

    public function findsupplier(){
        $tipCategory = CategoriaProveedor::all();
        $supplier = Proveedor::all();
        return view('purchase.find',compact('tipCategory','supplier'));
    }

    public function create(Request $request){
        $queryPurchase = OrdenCompra::orderBy('idorco','desc')
                               ->get();
        $value = count($queryPurchase);
        if ($value == 0 ){
            $value = 1;
        }
        $money = Moneda::all();
        $tipCategory = CategoriaProveedor::where('tip_prove',$request->get('category'))
                                         ->get();
        $supplier = $request->get('name');

        $nameSupplier = Proveedor::where('nombre',$supplier)
                                 ->get();
        $tipProve = $tipCategory->pluck('tip_prove')->values()->first();
        $categorySupplier = $nameSupplier->pluck('categoria')->values()->first();
        if ($tipProve == $categorySupplier) {
            
            return view('purchase.create',compact('value','money'))
                ->with('nameSupplier',$nameSupplier[0]);
        }else{
            Session::flash('error',"El proveedor no es correcto");
            return redirect()->route('findsupplier');
        }
        
        
    }

    public function storeorder(Request $request){
        $this->validate($request,[
            'days' => 'required|numeric',
        ]);
        
        $numConcept = intval($request->get('numconcept'));
        $tasa_cambio = floatval($request->get('tasa_cambio'));
        $purchase = new OrdenCompra();
        $purchase->idprov = $request->get('idprov');
        $purchase->numorden = $request->get('numorden');
        $purchase->stsorden = 'ACT';
        $purchase->tiempo_pago = $request->get('days');
        if (strlen($request->get('money')) > 3) {
            Session::flash('error','Debe seleccionar un tipo de moneda');
            return redirect()->route('findsupplier');
        }
        $purchase->moneda = $request->get('money');
        $purchase->save();    


        
        return redirect()->route('createdetorder',['numConcept' => $numConcept, 'tasa_cambio' => $tasa_cambio]);
    }

    public function createdetorder($numConcept,$tasa_cambio){
        $purchase = OrdenCompra::orderBy('idorco','desc')
                               ->take(1)
                               ->get();
        $idorco = $purchase->pluck('idorco')->values()->first();
        $idprov = $purchase->pluck('idprov')->values()->first();
        
        $supplier = Proveedor::where('idprov',$idprov)
                             ->get();
        $money = Moneda::all();
        $cantConcept = $numConcept;
        return view('purchase.detorder',compact('purchase','cantConcept','idorco','money','tasa_cambio'))
                ->with('supplier',$supplier[0])
                ->with('purchase',$purchase[0]);
    }

    public function storedetpurchase(Request $request){
        $numConcept = intval($request->get('numconcept'));
        OrdenCompra::where('idorco',$request->get('idorco'))->update([
            'moneda' => $request->get('money')
        ]);
        if (strlen($request->get('money')) > 3) {
            Session::flash('error','Seleccione un tipo de moneda');
            return redirect()->route('createdetorder',$numConcept);
        }
        $tasa_cambio = floatval($request->get('tasa_cambio'));
        if ($tasa_cambio == null && ($request->get('money') != 'BS')) {
           Session::flash('error','debe seleccionar una tasa de cambio');
           return redirect()->route('createdetorder',$numConcept);
        } 
        else {
            if ($numConcept == 1  ) {
                $amountUnit = floatval($request->get('amountUnit_0'));
                $amountTotal = floatval($request->get('total-amount0'));
                
                $detPurchase = new DetalleOrdenCompra();
                $detPurchase->idorco = $request->get('idorco');
                $detPurchase->descripcion = $request->get("concept_0");
                if ($request->get('money') != 'BS') {
                    if ($request->get('money') == 'USD' || $request->get('EUR')){
                        $detPurchase->montounitlocal = $amountUnit * $tasa_cambio;
                        $detPurchase->montounitmoneda = $amountUnit;
                        $detPurchase->montobienlocal = $amountTotal * $tasa_cambio;
                        $detPurchase->montobienmoneda = $amountTotal;
                        $detPurchase->tasa_cambio = $tasa_cambio;
                        $detPurchase->save();
                        $taxeslocal =  $detPurchase->montobienlocal * 0.16;
                        $taxesmoneda = $detPurchase->montobienmoneda * 0.16;
                        
                    }
                    else {
                        $detPurchase->montounitlocal = $amountUnit / $tasa_cambio;
                        $detPurchase->montounitmoneda =  $amountUnit;
                        $detPurchase->montobienlocal = $amountTotal / $tasa_cambio;
                        $detPurchase->montobienmoneda = $amountTotal;
                        $detPurchase->tasa_cambio = $tasa_cambio;
                        $detPurchase->save();
                        $taxeslocal =  $detPurchase->montobienlocal * 0.16;
                        $taxesmoneda = $detPurchase->montobienmoneda * 0.16;
                       
                    }
                    
                }
                else {
                    $detPurchase->montounitlocal = $amountTotal;
                    $detPurchase->montounitmoneda = 0;
                    $detPurchase->montobienlocal = $amountTotal;
                    $detPurchase->montobienmoneda = 0;
                    $detPurchase->tasa_cambio = 0;
                    $detPurchase->save();
                    $taxeslocal =  0;
                    $taxesmoneda = $detPurchase->montobienmoneda * 0.16;
                    
                }
               
                $idorco = $detPurchase->idorco;
                if ($request->get('iva') == 'S') {
                    $sumAmountlocal = DetalleOrdenCompra::where('idorco',$idorco)
                                                ->sum('montobienlocal');
                    $sumAmountmoneda = DetalleOrdenCompra::where('idorco',$idorco)
                                                    ->sum('montobienmoneda');
                    $taxeslocal =  floatval($sumAmountlocal * 0.16);
                    $taxesmoneda = floatval($sumAmountmoneda * 0.16);
                    $totPurchaselocal = floatval($sumAmountlocal + $taxeslocal);   
                    $totPurchasemoneda = floatval($sumAmountmoneda + $taxesmoneda);   
                    DetalleOrdenCompra::where('idorco', $idorco)->update([
                        'montoivalocal' => $taxeslocal,
                        'montoivamoneda' => $taxesmoneda,
                        'montototallocal' => $totPurchaselocal,
                        'montototalmoneda' => $totPurchasemoneda
                    ]);
                }
                else {
                    $sumAmountlocal = DetalleOrdenCompra::where('idorco',$idorco)
                                                        ->sum('montobienlocal');
                    $sumAmountmoneda = DetalleOrdenCompra::where('idorco',$idorco)
                                                        ->sum('montobienmoneda');
                    DetalleOrdenCompra::where('idorco', $idorco)->update([
                    'montoivalocal' => 0,
                    'montoivamoneda' => 0,
                    'montototallocal' => $sumAmountlocal,
                    'montototalmoneda' => $sumAmountmoneda
                    ]);
                }
                
            }
            else {
                
                for ($i=0; $i < $numConcept; $i++) { 
                    $amountUnit = floatval($request->get("amountUnit_" . $i));
                    $amountTotal = floatval($request->get("total-amount" . $i));
                     
                    $detPurchase = new DetalleOrdenCompra();
                    $detPurchase->idorco = $request->get('idorco');
                    $detPurchase->descripcion = $request->get("concept_" . $i);
                    if ($request->get('money') != 'BS') {
                        if ($request->get('money') == 'USD' || $request->get('EUR')){
                            $detPurchase->montounitlocal = $amountUnit * $tasa_cambio;
                            $detPurchase->montounitmoneda = $amountUnit;
                            $detPurchase->montobienlocal = $amountTotal * $tasa_cambio;
                            $detPurchase->montobienmoneda = $amountTotal;
                            $detPurchase->tasa_cambio = $tasa_cambio;
                            $detPurchase->save();
                            $taxeslocal =  $detPurchase->montobienlocal * 0.16;
                            $taxesmoneda = $detPurchase->montobienmoneda * 0.16;
                            $amountTotlocal = $taxeslocal + $detPurchase->montobienlocal;
                            $amountTotmoneda = $taxesmoneda + $detPurchase->montobienmoneda;
                        }
                        else {
                            $detPurchase->montounitlocal = $amountUnit / $tasa_cambio;
                            $detPurchase->montounitmoneda =  $amountUnit;
                            $detPurchase->montobienlocal = $amountTotal / $tasa_cambio;
                            $detPurchase->montobienmoneda = $amountTotal;
                            $detPurchase->tasa_cambio = $tasa_cambio;
                            $detPurchase->save();
                            $taxeslocal =  $detPurchase->montobienlocal * 0.16;
                            $taxesmoneda = $detPurchase->montobienmoneda * 0.16;
                            $amountTotlocal = $taxeslocal + $detPurchase->montobienlocal;
                            $amountTotmoneda = $taxesmoneda + $detPurchase->montobienmoneda;
                        }
                    }
                    else {
                        $detPurchase->montounitlocal = $amountUnit;
                        $detPurchase->montounitmoneda = 0;
                        $detPurchase->montobienlocal = $amountTotal;
                        $detPurchase->montobienmoneda = 0;
                        $detPurchase->tasa_cambio = 0;
                        $detPurchase->save();
                        $taxeslocal =  0;
                        $taxesmoneda = $detPurchase->montobienmoneda * 0.16;
                        $amountTotlocal = 0;
                        $amountTotmoneda = $taxesmoneda + $detPurchase->montobienmoneda;
                    }
                   
                    $idorco = $detPurchase->idorco;
                    if ($request->get('iva') == 'S') {
                        $sumAmountlocal = DetalleOrdenCompra::where('idorco',$idorco)
                                                    ->sum('montobienlocal');
                        $sumAmountmoneda = DetalleOrdenCompra::where('idorco',$idorco)
                                                        ->sum('montobienmoneda');
                        $taxeslocal =  floatval($sumAmountlocal * 0.16);
                        $taxesmoneda = floatval($sumAmountmoneda * 0.16);
                        $totPurchaselocal = floatval($sumAmountlocal + $taxeslocal);   
                        $totPurchasemoneda = floatval($sumAmountmoneda + $taxesmoneda);   
                        DetalleOrdenCompra::where('idorco', $idorco)->update([
                            'montoivalocal' => $taxeslocal,
                            'montoivamoneda' => $taxesmoneda,
                            'montototallocal' => $totPurchaselocal,
                            'montototalmoneda' => $totPurchasemoneda
                        ]);
                    }
                    else {
                        $sumAmountlocal = DetalleOrdenCompra::where('idorco',$idorco)
                                                            ->sum('montobienlocal');
                        $sumAmountmoneda = DetalleOrdenCompra::where('idorco',$idorco)
                                                            ->sum('montobienmoneda');
                        DetalleOrdenCompra::where('idorco', $idorco)->update([
                        'montoivalocal' => 0,
                        'montoivamoneda' => 0,
                        'montototallocal' => $sumAmountlocal,
                        'montototalmoneda' => $sumAmountmoneda
                        ]);
                    }
                }
            }
        }
        return redirect()->route('totalorder', ['idorco' => $idorco]);
    }

    public function totalorder($idorco){
        $detailPurchase = DetalleOrdenCompra::where('idorco',$idorco)
                                            ->get();
                                            //dd($detailPurchase);
        $amountPurchase = DetalleOrdenCompra::select('montoivalocal','montoivamoneda','montototallocal','montototalmoneda')
                                            ->where('idorco',$idorco)
                                            ->first();
        $sumAmountlocal = DetalleOrdenCompra::where('idorco',$idorco)
                                        ->sum('montobienlocal');
        $sumAmountmoneda = DetalleOrdenCompra::where('idorco',$idorco)
                                        ->sum('montobienmoneda');
        $money = OrdenCompra::select('moneda')
                            ->where('idorco',$idorco)
                            ->first();
       
        
        return view('purchase.total',['detailPurchase' => $detailPurchase],compact('amountPurchase','idorco','sumAmountlocal','sumAmountmoneda','money'));
    }

    public function deleteorderco($idorco){
        $conceptPurchase = DetalleOrdenCompra::where('idorco',$idorco)->delete();
        $Purchase = OrdenCompra::where('idorco',$idorco)->delete();
        
        return redirect()->route('findsupplier');
    }
    public function deleteordercom($idorco){
        
        $Purchase = OrdenCompra::where('idorco',$idorco)->delete();
        
        return redirect()->route('findsupplier');
    }

    public function autorizar($idorco){
        $fecAuthorize = Carbon::now()->format('Y-m-d');
        $user = Auth::user();
        $username = $user->name;
    
        OrdenCompra::where('idorco', $idorco)->update([
            'stsorden' => 'AUT',
            'fec_autoriza' => $fecAuthorize,
            'autorizacion' => $username
        ]);
        Session::flash('auto','Se ha autorizado la orden de Compra');
        return redirect()->route('reportorder');
    }
}
