<?php

namespace App\Http\Controllers;

use App\Models\CategoriaProveedor;
use Illuminate\Http\Request;
use App\Models\Proveedor;
use App\Models\OrdenCompra;
use App\Models\DetalleOrdenCompra;
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
                                     'orden_compras.stsorden','orden_compras.tiempo_pago')
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

        $tipCategory = CategoriaProveedor::where('tip_prove',$request->get('category'))
                                         ->get();
        $supplier = $request->get('name');

        $nameSupplier = Proveedor::where('nombre',$supplier)
                                 ->get();
        $tipProve = $tipCategory->pluck('tip_prove')->values()->first();
        $categorySupplier = $nameSupplier->pluck('categoria')->values()->first();
        if ($tipProve == $categorySupplier) {
            
            return view('purchase.create',compact('value'))
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
        
        $numConcept = $request->get('numconcept');
        $purchase = new OrdenCompra();
        $purchase->idprov = $request->get('idprov');
        $purchase->numorden = $request->get('numorden');
        $purchase->stsorden = 'ACT';
        $purchase->tiempo_pago = $request->get('days');
        $purchase->save();    
        
        return redirect()->route('createdetorder',$numConcept);
    }

    public function createdetorder($numConcept){
        $purchase = OrdenCompra::orderBy('idorco','desc')
                               ->take(1)
                               ->get();
        $idprov = $purchase->pluck('idprov')->values()->first();
        
        $supplier = Proveedor::where('idprov',$idprov)
                             ->get();
        $cantConcept = $numConcept;
        return view('purchase.detorder',compact('purchase','cantConcept'))
                ->with('supplier',$supplier[0])
                ->with('purchase',$purchase[0]);
    }

    public function storedetpurchase(Request $request){
        $numConcept = intval($request->get('numconcept'));
        $taxes = 0;
        $amountTot = 0;
        $totPurchase = 0;
        if ($numConcept == 1  ) {
            $detPurchase = new DetalleOrdenCompra();
            $detPurchase->idorco = $request->get('idorco');
            $detPurchase->descripcion = $request->get("concept_0");
            $detPurchase->monto_unit = $request->get("amountUnit_0");
            $detPurchase->monto_bien = $request->get("total-amount0");

            $taxes =  $detPurchase->monto_bien * 0.16;
            $amountTot = $taxes + $detPurchase->monto_bien;

            $detPurchase->monto_iva = $taxes;
            $detPurchase->monto_total = $amountTot;
            $detPurchase->save();
            $idorco = $detPurchase->idorco;
            $sumAmount = DetalleOrdenCompra::where('idorco',$idorco)
                                            ->sum('monto_bien');
            $taxes =  floatval($sumAmount * 0.16);
            $totPurchase = floatval($sumAmount + $taxes);   
            DetalleOrdenCompra::where('idorco', $idorco)->update([
                'monto_iva' => $taxes,
                'monto_total' => $totPurchase
            ]);
        }
        else {
            
            for ($i=0; $i < $numConcept; $i++) { 
                $detPurchase = new DetalleOrdenCompra();
                $detPurchase->idorco = $request->get('idorco');
                $detPurchase->descripcion = $request->get("concept_" . $i);
                $detPurchase->monto_unit = $request->get("amountUnit_" . $i);
                $detPurchase->monto_bien = $request->get("total-amount" . $i);
                $detPurchase->save();
            }
            $idorco = $detPurchase->idorco;
            $sumAmount = DetalleOrdenCompra::where('idorco',$idorco)
                                            ->sum('monto_bien');
            $taxes =  floatval($sumAmount * 0.16);
            $totPurchase = floatval($sumAmount + $taxes);   
            DetalleOrdenCompra::where('idorco', $idorco)->update([
                'monto_iva' => $taxes,
                'monto_total' => $totPurchase
            ]);
        }

        return redirect()->route('totalorder', ['idorco' => $idorco]);
        
    }

    public function totalorder($idorco){
        $detailPurchase = DetalleOrdenCompra::where('idorco',$idorco)
                                            ->get();
        $amountPurchase = DetalleOrdenCompra::select('monto_iva','monto_total')
                                            ->where('idorco',$idorco)
                                            ->first();
        $sumAmount = DetalleOrdenCompra::where('idorco',$idorco)
                                        ->sum('monto_bien');
       
        
        return view('purchase.total',['detailPurchase' => $detailPurchase],compact('amountPurchase','idorco','sumAmount'));
    }

    public function deleteorderco($idorco){
        $conceptPurchase = DetalleOrdenCompra::where('idorco',$idorco)->delete();
        $Purchase = OrdenCompra::where('idorco',$idorco)->delete();
        
        return redirect()->route('reportorder');
    }

    public function autorizar($idorco){
        $fecAuthorize = Carbon::now()->format('d/m/y');
        $user = Auth::user();
        $username = $user->name;
    
        OrdenCompra::where('idorco', $idorco)->update([
            'stsorden' => 'AUT',
            'fec_autoriza' => $fecAuthorize,
            'autorizacion' => $username
        ]);

        return redirect()->route('reportorder');
    }
}
