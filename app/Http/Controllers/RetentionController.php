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
use App\Models\Cliente;
use App\Models\DetalleRetencionIngreso;
use App\Models\DetFact;
use App\Models\Factura;
use App\Models\Ingreso;
use App\Models\RetencionIngreso;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Session;

class RetentionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:listpay')->only('index');
        $this->middleware('can:createretention')->only('create','store','pdf');
        $this->middleware('can:createretening')->only('createretening','storeretening','totalretentioniva');
    }

    public function index(){
        $registerOrderPay = OrdenPago::join('detalle_orden_pagos','orden_pagos.idorpa','=','detalle_orden_pagos.idorpa')
                                     ->select('orden_pagos.idorpa','orden_pagos.idprov','orden_pagos.numfact','orden_pagos.numctrl','orden_pagos.moneda',
                                     'detalle_orden_pagos.montototallocal','detalle_orden_pagos.baseimponiblelocal','detalle_orden_pagos.montototalmoneda','orden_pagos.num_egre')
                                     ->where('orden_pagos.stsorpa','PAG')
                                     ->where('detalle_orden_pagos.indiva','S')
                                     ->get();
        $registerIncome = Factura::join('det_facts','facturas.idfact','=','det_facts.idfact')
                                 ->select('det_facts.fec_emi','det_facts.numfact','det_facts.numctrl','det_facts.mtoimponiblelocal', 
                                        'facturas.idfact','facturas.idcli')
                                 ->where('det_facts.stsfact','INC')
                                 ->orderBy('fec_emi','asc')
                                 ->get();
        $idprov = $registerOrderPay->pluck('idprov');
        $supplier = Proveedor::select('nombre','tipid','identificacion','tiprif')
                            ->whereIn('idprov',$idprov)->get();
                            //dd($supplier);
        
        return view('retention.index',compact('registerOrderPay','registerIncome','supplier'));
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

    public function createretening($idfact,$idcli){
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
            
            $customer = Cliente::find($idcli);
            $registerIncome = Factura::join('det_facts','facturas.idfact','=','det_facts.idfact')
                                     ->select('facturas.idfact','det_facts.iddfact','facturas.idcli','det_facts.numfact','det_facts.numctrl'
                                            ,'det_facts.fec_emi','facturas.moneda','det_facts.mtoimpuestolocal')
                                     ->where('det_facts.stsfact','INC')
                                     ->where('facturas.idfact',$idfact)
                                     ->first();
        return view('retention.createing',compact('registerIncome','customer','fecEmi','perFiscal','month','nVoucher','numOper'));

    }
    public function store(Request $request){
        
        $this->validate($request,[
            'numfact' => 'required',
            'numctrl' => 'required',
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
        $supplier = Proveedor::find(intval($request->get('idprov')));
        $seatAmount = new Asiento();
        $seatAmount->fec_asi = $request->get('fecemi');
        $seatAmount->observacion = "Pago de Retención de Iva de " . $supplier->nombre;
        $seatAmount->idcta1 = 85;
        $seatAmount->idcta2 = 35;
        $seatAmount->descripcion = "Pago de Retención de Iva de " . $supplier->nombre;
        $seatAmount->monto_deb = floatval($request->get('taxesreten'));
        $seatAmount->monto_hab = floatval($request->get('taxesreten'));
        $seatAmount->save();
        
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
        $detRetention->fecemifact = $request->get('fecemi');
        if ($request->get('numfact') != $pay->numfact) {
            $retention = Retencion::where('idret',$retention->idret)->delete();
            $seat = Asiento::where('idasi',$seatAmount->idasi)->delete();
            Session::flash('error','el numero de factura no coincide con el Pago registrado');
            return redirect()->route('createretention',['idorpa' => intval($request->get('idorpa')), 'idprov' => intval($request->get('idprov'))]);
        }
        elseif ($request->get('numctrl') != $pay->numctrl) {
            $retention = Retencion::where('idret',$retention->idret)->delete();
            $seat = Asiento::where('idasi',$seatAmount->idasi)->delete();
            Session::flash('error','el numero de control de factura no coincide con el Pago registrado');
            return redirect()->route('createretention',['idorpa' => intval($request->get('idorpa')), 'idprov' => intval($request->get('idprov'))]);
        }
        $detRetention->numfact = $request->get('numfact');
        $detRetention->numctrl = $request->get('numctrl');
        $detRetention->totalfact = floatval($request->get('totaltaxes'));
        $detRetention->baseimponible = floatval($request->get('base'));
        $detRetention->montoimpuesto = floatval($request->get('taxes'));
        $detRetention->impuestoretenido = floatval($request->get('taxesreten'));
        $detRetention->save();

        OrdenPago::where('idorpa',intval($request->get('idorpa')))->update([
            'stsorpa' => 'PEN'
        ]);

        Session::flash('se ha realizado la Retención de IVA correctamente');
        return redirect()->route('totalretentioniva',['idret' => $retention->idret, 'inding' => 'N']);

    }

    public function storeretening(Request $request){
        $this->validate($request,[
            'numfact' => 'required',
            'numctrl' => 'required',
            'base' => 'required',
            'iva' => 'required',
            'totaltaxes' => 'required',
            'taxes' => 'required',
            'taxesreten' => 'required',
        ]);
        $customer = Cliente::find(intval($request->get('idcli')));
        $invoice = Factura::join('det_facts','facturas.idfact','=','det_facts.idfact')
                        ->select('facturas.idfact','det_facts.iddfact','det_facts.numfact','det_facts.numctrl')
                        ->where('facturas.idfact',intval($request->get('idfact')))
                        ->first();
                       
        $income = Ingreso::where('iddfact',intval($invoice->iddfact))->first();

        $seatAmount = new Asiento();
        $seatAmount->fec_asi = $request->get('fecemi');
        $seatAmount->observacion = "Pago de Retención IVA por ingresos de " . $customer->nombre;
        $seatAmount->idcta1 = 84;
        $seatAmount->idcta2 = 35;
        $seatAmount->descripcion = "Pago de Retención IVA por ingresos de " . $customer->nombre;
        $seatAmount->monto_deb = floatval($request->get('taxesreten'));
        $seatAmount->monto_hab = floatval($request->get('taxesreten'));
        $seatAmount->save();

        $retention = new RetencionIngreso();
        $retention->iding = intval($income->iding);
        $retention->idasi = $seatAmount->idasi;
        $retention->idcli = intval($request->get('idcli'));
        $retention->idfact = intval($request->get('idfact'));
        $retention->ncomprobante = $request->get('nvoucher');
        $retention->fecemi = $request->get('fecemi');
        $retention->fecrecep= $request->get('fecemi');
        $retention->save();

        $detRetention = new DetalleRetencionIngreso();
        $detRetention->idrein = $retention->idrein;
        $detRetention->fecemifact = $request->get('fecemifact');
        if ($request->get('numfact') != $invoice->numfact) {
            $retention = RetencionIngreso::where('idrein',$retention->idrein)->delete();
            $seat = Asiento::where('idasi',$seatAmount->idasi)->delete();
           
            Session::flash('error','el numero de factura no coincide con el Pago registrado');
            return redirect()->route('createretening',['idfact' => intval($request->get('idfact')), 'idcli' => intval($request->get('idcli'))]);
        }
        elseif ($request->get('numctrl') != $invoice->numctrl) {
            $retention = RetencionIngreso::where('idrein',$retention->idrein)->delete();
            $seat = Asiento::where('idasi',$seatAmount->idasi)->delete();
           
            Session::flash('error','el numero de control de factura no coincide con el Pago registrado');
            return redirect()->route('createretening',['idfact' => intval($request->get('idfact')), 'idcli' => intval($request->get('idcli'))]);
        }
        $detRetention->numfact = $request->get('numfact');
        $detRetention->numctrl = $request->get('numctrl');
        $detRetention->totalfact = floatval($request->get('totaltaxes'));
        $detRetention->baseimponible = floatval($request->get('base'));
        $detRetention->montoimpuesto = floatval($request->get('taxes'));
        $detRetention->impuestoretenido = floatval($request->get('taxesreten'));
        $detRetention->save();

        DetFact::where('idfact',intval($request->get('idfact')))->update([
            'stsfact' => 'RET'
        ]);

        Session::flash('se ha realizado la Retención de IVA correctamente');
        return redirect()->route('totalretentioniva',['idret' => $retention->idrein,'inding' => 'S']);
    }

    public function totalretentioniva($idret,$inding){
        if ($inding == 'S') {
            $retention = RetencionIngreso::where('idrein',$idret)->first();
            $detRetention = DetalleRetencionIngreso::where('idrein',$idret)->first();
            $suject = Cliente::where('idcli',intval($retention->idcli))->first();

            return view('retention.total',compact('retention','detRetention','suject','inding'));
        }else {
            $retention = Retencion::where('idret',$idret)->first();
            $detRetention = DetalleRetencion::where('idret',$idret)->first();
            $suject = Proveedor::where('idprov',intval($retention->idprov))->first();
            return view('retention.total',compact('retention','detRetention','suject','inding'));
        }
    }

    public function pdf($idret,$inding){
        
        if ($inding == 'S') {
            $retention = RetencionIngreso::where('idrein',$idret)->first();
            $detRetention = DetalleRetencionIngreso::where('idrein',$idret)->first();
            $suject = Cliente::where('idcli',intval($retention->idcli))->first();
            
            $fecha = Carbon::parse($retention->fecemi); // Convierte la cadena de texto en un objeto Carbon
            $year = $fecha->format('Y');

            
            
        }else {
            $retention = Retencion::where('idret',$idret)->first();
            $detRetention = DetalleRetencion::where('idret',$idret)->first();
            $suject = Proveedor::where('idprov',intval($retention->idprov))->first();
            $fecha = Carbon::parse($retention->fecemi); // Convierte la cadena de texto en un objeto Carbon
            $year = $fecha->format('Y');
        }


        $imagePath = storage_path("img/logo.png");
      //  $image = "data:img/logo.png;base64,".base64_encode(file_get_contents($imagePath));     
        $image = base64_encode(file_get_contents($imagePath));
        

        $pdf = PDF::loadView('retention.comproiva',compact('image','year','retention','detRetention','suject'));
        
        return $pdf->download("retencioniva_" . $suject->nombre . ".pdf");
    } 
}
