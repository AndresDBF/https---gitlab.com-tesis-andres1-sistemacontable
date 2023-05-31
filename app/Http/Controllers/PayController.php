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
}
