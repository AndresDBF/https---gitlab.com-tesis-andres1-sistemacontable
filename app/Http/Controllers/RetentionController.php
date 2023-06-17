<?php

namespace App\Http\Controllers;

use App\Models\Asiento;
use App\Models\OrdenPago;
use App\Models\DetalleOrdenPago;
use App\Models\Retencion;
use App\Models\DetalleRetencion;
use App\Models\Proveedor;
use App\Models\ComprobantePago;
use App\Models\CatgCuenta;
use App\Models\CatgSubCuenta;
use App\Models\CatCuenta;
use App\Models\CatSubGru;
use App\Models\CatGrupo;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class RetentionController extends Controller
{
    public function index(){
        $registerOrderPay = OrdenPago::join('detalle_orden_pagos','orden_pagos.idorpa','=','detalle_orden_pagos.idorpa')
                                     ->select('orden_pagos.idorpa','orden_pagos.idprov','orden_pagos.numfact','orden_pagos.fec_emi','orden_pagos.moneda',
                                     'detalle_orden_pagos.montototallocal','detalle_orden_pagos.montototalmoneda')
                                     ->where('orden_pagos.stsorpa','PAG')
                                     ->get();
        $idprov = $registerOrderPay->pluck('idprov');
        $supplier = Proveedor::select('nombre','tipid','identificacion','tiprif')
                            ->whereIn('idprov',$idprov)->get();
                            //dd($supplier);
        
        return view('retention.index',compact('registerOrderPay','supplier'));
    }

    public function create($idorpa,$idprov){
        $fecEmi = Carbon::now()->format('Y-m-d');
        $perFiscal = Carbon::now()->format('Y');
        $month = Carbon::now()->format('m');
        $retention = Retencion::orderBy('idret','asc')
                             ->take(1)
                             ->get();
        $countReten = count($retention);
        if ($countReten < 1) {
            $formatVoucher = Carbon::now()->format('Ymd');
            $numOper = 1;
            $nVoucher = ($formatVoucher . '000' . 1);
        }
        else {
            $formatVoucher = Carbon::now()->format('Ymd');
            $numOper = $countReten + 1;
            $nVoucher = ($formatVoucher . '000' . intval($countReten + 1));
        }
        
        $supplier = Proveedor::where('idprov',$idprov)->first();
        $registerOrderPay = OrdenPago::join('detalle_orden_pagos','orden_pagos.idorpa','=','detalle_orden_pagos.idorpa')
                                    ->select('orden_pagos.idorpa','orden_pagos.idprov','orden_pagos.numfact','orden_pagos.numctrl',
                                    'orden_pagos.fec_emi','orden_pagos.moneda','detalle_orden_pagos.montototallocal',
                                    'detalle_orden_pagos.montototalmoneda')
                                    ->where('orden_pagos.stsorpa','PAG')
                                    ->where('orden_pagos.idorpa',$idorpa)
                                    ->first();
        return view('retention.create',compact('registerOrderPay','supplier','fecEmi','perFiscal','month','nVoucher','numOper'));
    }
    public function store(Request $request){

        $this->validate($request,[
            'numfact' => 'required',
            'numcontrl' => 'required',
            'base' => 'required',
            'iva' => 'required',
            'totaltaxes' => 'required',
            'taxes' => 'required',
            'taxesreten' => 'required',
        ]);
        $pay = OrdenPago::join('comprobante_pagos','orden_pagos.idorpa','=','comprobante_pagos.idorpa')
                        ->select('comprobante_pagos.idpag','orden_pagos.numfact','orden_pagos.numctrl')
                        ->where('orden_pagos.idorpa',intval($request->get('idorpa')))
                        ->first();
        $idcta1 = CatgSubCuenta::select('idcta')
                                ->where('idscu', $request->get('subaccountname1'))
                                ->first();
        $idcta2 = CatgSubCuenta::where('idscu', $request->get('subaccountname2'))
                                ->first();
        
        $seatAmount = new Asiento();
        $seatAmount->fec_asi = $request->get('fecemi');
        $seatAmount->observacion = $request->get('observation');
        $seatAmount->idcta1 = $idcta1->idcta;
        $seatAmount->idcta2 = $idcta2->idcta;
        $seatAmount->descripcion = $request->get('description');
        $seatAmount->monto_deb = floatval($request->get('totaltaxes'));
        $seatAmount->monto_hab = floatval($request->get('totaltaxes'));
        $seatAmount->save();

        $seativa = new Asiento();
        $seativa->fec_asi = $request->get('fecemi');
        $seativa->observacion = $request->get('observation');
        $seativa->idcta1 = 84;
        $seativa->idcta2 = 84;
        $seativa->descripcion = $request->get('description');
        $seativa->monto_deb = floatval($request->get('totaltaxes'));
        $seativa->monto_hab = floatval($request->get('totaltaxes'));
        $seativa->save();

        $retention = new Retencion();
        $retention->idpag = $pay->idpag;
        $retention->idasi = $seatAmount->idasi;
        $retention->idprov = intval($request->get('idprov'));
        $retention->idorpa = intval($request->get('idorpa'));
        $retention->ncomprobante = $request->get('nvoucher');
        $retention->fecemi = $request->get('fecemi');
        $retention->fecrecep= $request->get('fecemi');
        $retention->save();

        $detRetention = new DetalleRetencion();
        $detRetention->idret = $retention->idret;
        $detRetention->fecemifact = $request->get('fec_emi');
        if ($request->get('numfact') != $pay->numfact) {
            Session::flash('error','el numero de factura no coincide con el Pago registrado');
            return redirect()->route('createretention',['idorpa' => intval($request->get('idorpa')), 'idprov' => intval($request->get('idprov'))]);
        }
        elseif ($request->get('numctrl') != $pay->numctrl) {
            Session::flash('error','el numero de control de factura no coincide con el Pago registrado');
            return redirect()->route('createretention',['idorpa' => intval($request->get('idorpa')), 'idprov' => intval($request->get('idprov'))]);
        }
        $detRetention->numfact = $request->get('numfact');
        $detRetention->numctrl = $request->get('numctrl');
        $detRetention->totalfact = floatval('totaltaxes');
        $detRetention->baseimponible = floatval('base');
        $detRetention->montoimpuesto = floatval('taxes');
        $detRetention->impuestoretenido = floatval('taxesreten');
        $detRetention->save();

        OrdenPago::where('idorpa',intval($pay->idorpa))->update([
            'stsorpa' => 'PEN'
        ]);

        Session::flash('se ha realizado la Retención de IVA correctamente');
        return redirect()->route('listpay');

    }

/*     public function pdf(){
        $retention = "hola";
        $pdf = Pdf::loadView('retention.retentionpdf', compact('retention'));
        return $pdf->download();
    } */
}
