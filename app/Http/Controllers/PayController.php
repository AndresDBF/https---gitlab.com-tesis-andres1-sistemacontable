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
use App\Models\ProyeccionGasto;
use App\Models\DetalleIngreso;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;
use Dompdf\Options;
use Barryvdh\DomPDF\Facade\Pdf;

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
        
        $payOrder = DetalleOrdenPago::where('idorpa', $request->get('idorpa'))->first();

        $presupuesto = ProyeccionGasto::orderBy('fecstsini', 'asc')->first();
        
        $presupuesto->presupuesto -= floatval($payOrder->montototallocal);
        
        $presupuesto->save();
      

        $proyect = ProyeccionGasto::orderBy('fecstsini','asc')->first();
        if ($proyect->presupuesto < 0) {
            $presupuesto->presupuesto -= -floatval($payOrder->montototallocal);
            $presupuesto->save();
            Session::flash('error','ha superado el monto total del presupuesto ');
            return redirect()->route('registerpay');
        }
        $idcta1 = CatgSubCuenta::select('idcta')
                                ->where('idscu', $request->get('subaccountname1'))
                                ->first();
        $idcta2 = CatgSubCuenta::where('idscu', $request->get('subaccountname2'))
                                ->first();
        $amount = floatval($payOrder->baseimponiblelocal);
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

        if ($request->get('indiva') == 'S') {
            $seatTaxes = new Asiento();
            $seatTaxes->fec_asi = $request->get('fecTransiction');
            $seatTaxes->observacion = $request->get('observation');
            $seatTaxes->idcta1 = 35;
            $seatTaxes->idcta2 = 84;
            $seatTaxes->descripcion = $request->get('description');
            $seatTaxes->monto_deb = $amountTaxes * 0.75;
            $seatTaxes->monto_hab = $amountTaxes * 0.75;
            $seatTaxes->save();
        }

        if ($payOrder->montototallocal > 750) {
            $seatTaxes = new Asiento();
            $seatTaxes->fec_asi = $request->get('fecTransiction');
            $seatTaxes->observacion = $request->get('observation');
            $seatTaxes->idcta1 = 37;
            $seatTaxes->idcta2 = 79;
            $seatTaxes->descripcion = $request->get('description');
            $seatTaxes->monto_deb = $amountTaxes;
            $seatTaxes->monto_hab = $amountTaxes;
            $seatTaxes->save();
        }
       
        if ($request->get('money') != 'BS') {
            $amountIgtf = $seatAmount->monto_deb * 0.03;

            $seatIgtf = new Asiento();
            $seatIgtf->fec_asi = $request->get('fecTransiction');
            $seatIgtf->observacion = $request->get('observation');
            $seatIgtf->idcta1 = 259;
            $seatIgtf->idcta2 = $idcta2->idcta;
            $seatIgtf->descripcion = $request->get('description');
            $seatIgtf->monto_deb = $amountIgtf;
            $seatIgtf->monto_hab = $amountIgtf;
            $seatIgtf->save();        
        }
        

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
            $proofPay->montolocal = $amount;
            $proofPay->montomoneda = 0;
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
        return redirect()->route('totalpay',['idorpa' => intval($request->get('idorpa')) , 'idprov' => intval($request->get('idprov'))]);     

    }

    public function totalpay($idorpa,$idprov){
       
        $payorder = OrdenPago::join('detalle_orden_pagos','orden_pagos.idorpa','=','detalle_orden_pagos.idorpa')
                            ->select('orden_pagos.num_egre','orden_pagos.numfact','orden_pagos.moneda','detalle_orden_pagos.indiva','orden_pagos.fec_emi',
                                    'detalle_orden_pagos.baseimponiblelocal','detalle_orden_pagos.baseimponiblemoneda','detalle_orden_pagos.montoivalocal',
                                    'detalle_orden_pagos.montoivamoneda','detalle_orden_pagos.montototallocal','detalle_orden_pagos.montototalmoneda')
                            ->where('orden_pagos.idorpa',$idorpa)
                            ->where('orden_pagos.stsorpa','PAG')
                            ->orderBy('orden_pagos.fec_emi','asc')
                            ->first();
                          
        $supplier = Proveedor::find($idprov);
        return view('pay.total',compact('payorder','supplier','idorpa','idprov'));
    }


    public function relegrepdf($idorpa,$idprov){
        $payorder = OrdenPago::join('detalle_orden_pagos','orden_pagos.idorpa','=','detalle_orden_pagos.idorpa')
                                ->select('orden_pagos.num_egre','orden_pagos.numfact','orden_pagos.moneda','detalle_orden_pagos.indiva','orden_pagos.fec_emi',
                                        'detalle_orden_pagos.baseimponiblelocal','detalle_orden_pagos.montoivalocal','detalle_orden_pagos.montototallocal')
                                ->where('orden_pagos.idprov',$idprov)
                                ->where('orden_pagos.stsorpa','PAG')
                                ->orderBy('orden_pagos.fec_emi','asc')
                                ->get();
                                
        $sumegre = OrdenPago::join('detalle_orden_pagos','orden_pagos.idorpa','=','detalle_orden_pagos.idorpa')
                                ->select('orden_pagos.num_egre','orden_pagos.numfact','orden_pagos.moneda','detalle_orden_pagos.indiva','orden_pagos.fec_emi',
                                        'detalle_orden_pagos.baseimponiblelocal','detalle_orden_pagos.montoivalocal',
                                        'detalle_orden_pagos.montototallocal')
                                ->where('orden_pagos.idprov',$idprov)
                                ->where('orden_pagos.stsorpa','PAG')
                                ->orderBy('orden_pagos.fec_emi','asc')
                                ->sum('detalle_orden_pagos.montototallocal');
        $fecini = OrdenPago::select('fec_emi')
                            ->where('idprov',$idprov)                 
                            ->where('stsorpa','PAG')
                            ->orderBy('fec_emi','asc')
                            ->first();
        $fecfin = OrdenPago::select('fec_emi')
                            ->where('idprov',$idprov)                 
                            ->where('stsorpa','PAG')
                            ->orderBy('fec_emi','desc')
                            ->first();
        $supplier = Proveedor::find($idprov);
                    
        $imagePath = storage_path("img/logo.png");
        $image = base64_encode(file_get_contents($imagePath));
        $options = new Options();
        $options->set('isRemoteEnabled', true); // Permite cargar imágenes desde URL
        $options->set('defaultFont', 'Arial'); // Fuente predeterminada
        $options->set('orientation', 'landscape'); // Orientación horizontal
        $options->set('size', 'letter'); // Tamaño de página: carta (letter)

        $dompdf = new Dompdf($options);

        $view = view('pay.relegrepdf', compact('payorder','sumegre', 'fecini','supplier','fecfin', 'image'))->render();
        $dompdf->loadHtml($view);
        $dompdf->render();

        return $dompdf->stream("Reporte_Egresos_". $supplier->nombre . ".pdf");
    }
    //for find idcta
    public function groupaccount1()
    {
        return CatGrupo::all();
    }
    public function subgroupaccount1(Request $request)
    {
        return CatSubGru::where("idgru",$request->idgru)->orderBy('descripcion','asc')->get();
    }
    public function accountname1(Request $request)
    {
        return CatgCuenta::where("idsgr",$request->idsgr)->orderBy('descripcion','asc')->get();
    }
    public function subaccountname1(Request $request)
    {
        return CatgSubCuenta::where('idgcu',$request->idgcu)->orderBy('descripcion','asc')->get();
    }

    public function groupaccount2()
    {
        return CatGrupo::all();
    }
    public function subgroupaccount2(Request $request)
    {
        return CatSubGru::where("idgru",$request->idgru)->orderBy('descripcion','asc')->get();
    }
    public function accountname2(Request $request)
    {
        return CatgCuenta::where("idsgr",$request->idsgr)->orderBy('descripcion','asc')->get();
    }
    public function subaccountname2(Request $request)
    {
        return CatgSubCuenta::where('idgcu',$request->idgcu)->orderBy('descripcion','asc')->get();
    }

}
