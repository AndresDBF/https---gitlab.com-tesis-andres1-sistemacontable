<?php

namespace App\Http\Controllers;

use App\Models\OrdenPago;
use Illuminate\Http\Request;
use App\Models\Proveedor;
use App\Models\DetalleOrdenPago;
use App\Models\GastoOperativo;
use App\Models\DetalleGastoOperativo;
use App\Models\ConceptoGasto;
use App\Models\Moneda;
use App\Models\CatGrupo;
use App\Models\CatSubGru;
use App\Models\CatgCuenta;
use App\Models\CatgSubCuenta;
use App\Models\TipPago;
use Carbon\Carbon;
use App\Models\Asiento;
use App\Models\ComprobantePago;
use App\Models\DetalleComprobantePago;
use App\Models\DetalleIngreso;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Stmt\Else_;

class PayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $registerPay = Proveedor::join('orden_pagos','proveedors.idprov','=','orden_pagos.idprov')
                                    ->select('orden_pagos.idorpa','orden_pagos.idprov','orden_pagos.num_egre','orden_pagos.fec_emi',
                                    'orden_pagos.moneda','orden_pagos.tippago','proveedors.nombre')
                                    ->where('orden_pagos.stsorpa','ACT')
                                    ->orderBy('proveedors.nombre','asc')
                                    ->orderBy('orden_pagos.idorpa','asc')
                                    ->get();
        $idorpa = $registerPay->pluck('idorpa')->values();

        $detPayOrder = DetalleOrdenPago::whereIn('idorpa',$idorpa)
                                        ->orderBy('idorpa','asc')
                                        ->get();
        
        return view('pay.index',compact('registerPay','detPayOrder'));
    }

    public function create($idprov,$idorpa){
        $valueIdprov = $idprov;
        $valueIdorpa = $idorpa;
        $payorder = OrdenPago::where('idorpa',$idorpa)
                          ->first();   
        $fecTransaction =  Carbon::now()->format('Y-m-d');
        $detPayOrder = DetalleOrdenPago::where('idorpa',$idorpa)
                                        ->first();
        $supplier = Proveedor::where('idprov',$idprov)->first();
        $money = Moneda::all();
        $formPay = TipPago::where('tip_proceso','ingresos_gastos')
                          ->orderBy('descripcion')
                          ->get();
                          
        return view('pay.create',compact('payorder','fecTransaction','detPayOrder','supplier','money','formPay','valueIdorpa','valueIdprov'));

    }

    public function store(Request $request){
        $this->validate($request, [
            'numconfirm' => 'required|numeric',
            'conceptDesc' => 'required',
            'description' => 'required',
            'observation' => 'required',
            'descriptionseat' => 'required',
        ]);
        $payOrder = DetalleOrdenPago::where('idorpa',$request->get('idorpa'))->first();
        
        $idcta1 = CatgSubCuenta::select('idcta')
                                ->where('idscu', $request->get('subaccountname1'))
                                ->first();
        $idcta2 = CatgSubCuenta::where('idscu', $request->get('subaccountname2'))
                                ->first();
        
        $amount = floatval($request->get('amount'));
        $amountTaxes = floatval($payOrder->montoivalocal);
        $tasa = $payOrder->tasa_cambio;
        $seatAmount = new Asiento();
        $seatAmount->fec_asi = $request->get('fecTransiction');
        $seatAmount->observacion = $request->get('observation');
        $seatAmount->idcta1 = $idcta1->idcta;
        $seatAmount->idcta2 = $idcta2->idcta;
        $seatAmount->descripcion = $request->get('description');
        if ($request->get('money') != 'BS') {
            if ($request->get('money') == 'USD' || $request->get('money') == 'EUR') {
                $seatAmount->monto_deb = $amount * $tasa;
                $seatAmount->monto_hab = $amount * $tasa;
            } else {
                $seatAmount->monto_deb = $amount / $tasa;
                $seatAmount->monto_hab = $amount / $tasa;
            }
        }
        else{
            $seatAmount->monto_deb = $amount;
            $seatAmount->monto_hab = $amount;
        }
        $seatAmount->save();

        $seatTaxes = new Asiento();
        $seatTaxes->fec_asi = $request->get('fecTransiction');
        $seatTaxes->observacion = $request->get('observation');
        $seatTaxes->idcta1 = 85;
        $seatTaxes->idcta2 = 85;
        $seatTaxes->descripcion = $request->get('description');
        $seatTaxes->monto_deb = $amountTaxes;
        $seatTaxes->monto_hab = $amountTaxes;
        $seatTaxes->save();

        $amountIgtf = $seatAmount->monto_deb * 0.03;

        $seatIgtf = new Asiento();
        $seatIgtf->fec_asi = $request->get('fecTransiction');
        $seatIgtf->observacion = $request->get('observation');
        $seatIgtf->idcta1 = 88;
        $seatIgtf->idcta2 = 88;
        $seatIgtf->descripcion = $request->get('description');
        $seatIgtf->monto_deb = $amountIgtf;
        $seatIgtf->monto_hab = $amountIgtf;
        $seatIgtf->save();

        $proofPay = new ComprobantePago();
        $proofPay->idorpa = $request->get('idorpa');
        $proofPay->idasi = $seatAmount->idasi;
        $proofPay->numconfirm = $request->get('numconfirm');
        $proofPay->moneda = $request->get('money');
        if ($request->get('money') == 'USD' || $request->get('money') == 'EUR') {
            $proofPay->montolocal =  $amount;
            $proofPay->montomoneda = $amount * $tasa;
        }
        elseif ($request->get('money') == 'COP' ){
            $proofPay->montolocal =  $amount;
            $proofPay->montomoneda = $amount / $tasa;
        }
        elseif($request->get('money') == 'BS'){
            $proofPay->montolocal = 0;
            $proofPay->montomoneda = $amount;
        }
        $proofPay->cantidad_escr = $request->get('conceptDesc');
        $proofPay->tasa_cambio = $payOrder->tasa_cambio;
        $proofPay->save();

        $detProofPay = new DetalleComprobantePago();
        $detProofPay->idpag = $proofPay->idpag;
        $detProofPay->idprov = $request->get('idprov');
        $detProofPay->fec_trans = $request->get('fecTransiction');
        $detProofPay->formpago = $request->get('formPay');
        $detProofPay->descripcion = $request->get('description');
        $detProofPay->save();

        OrdenPago::where('idorpa',$request->get('idorpa'))->update([
            'stsorpa' => 'PAG'
        ]);
        Session::flash('mensaje','se ha realizado el Registro de Pago correctamente');
        return redirect()->route('registerpay');     

    }

    //for find idcta
    public function groupaccount1()
    {
        return CatGrupo::all();
    }
    public function subgroupaccount1(Request $request)
    {
        return CatSubGru::where("idgru",$request->idgru)->get();
    }
    public function accountname1(Request $request)
    {
        return CatgCuenta::where("idsgr",$request->idsgr)->get();
    }
    public function subaccountname1(Request $request)
    {
        return CatgSubCuenta::where('idgcu',$request->idgcu)->get();
    }

    public function groupaccount2()
    {
        return CatGrupo::all();
    }
    public function subgroupaccount2(Request $request)
    {
        return CatSubGru::where("idgru",$request->idgru)->get();
    }
    public function accountname2(Request $request)
    {
        return CatgCuenta::where("idsgr",$request->idsgr)->get();
    }
    public function subaccountname2(Request $request)
    {
        return CatgSubCuenta::where('idgcu',$request->idgcu)->get();
    }

}
