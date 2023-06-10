<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factura;
use App\Models\DetFact;
use App\Models\Cliente;
use App\Models\ComprobanteIngreso;
use App\Models\ContrCli;
use App\Models\DetComprobanteIng;
use App\Models\CatCuenta;
use App\Models\CatGrupo;
use App\Models\CatSubGru;
use App\Models\CatgCuenta;
use App\Models\CatgSubCuenta;
use App\Models\Asiento;
use App\Models\DetalleIngreso;
use App\Models\Ingreso;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class IncomeController extends Controller
{ 
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function searchIncome(){
        $customer = Cliente::join('contr_clis','clientes.idcli','=','contr_clis.idcli')
                        ->select('clientes.idcli','clientes.nombre','clientes.tipid','clientes.identificacion','clientes.tiprif','clientes.telefono', 
                        'clientes.email','contr_clis.stscontr','contr_clis.tip_pag')
                        ->orderBy('clientes.nombre')
                        ->get();
        return view('income.search',compact('customer'));
    }
    
    public function findIncome(Request $request){
        
      
        $identification = $request->get('customer');
        $customer = Cliente::where('identificacion', $identification)->first();

        if (!$customer) {
            Session::flash('error','no se ha encontrado el cliente');
            return redirect()->route('searchIncome');
        }

        $findInvoice = Factura::where('idcli', $customer->idcli)->get();
        $invoiceId = $findInvoice->pluck('idfact');

        $findDetInvoice = DetFact::whereIn('idfact', $invoiceId)
                                ->where('stsfact', 'PAG')
                                ->get();
        $valueDetInvoice = count($findDetInvoice);
        if ($valueDetInvoice < 1) {
            Session::flash('error','No hay giros por cobrar para este cliente');
            return redirect()->route('searchIncome');
        }

        $nameCli = Cliente::where('idcli',$customer->idcli)->get();

        return view('income.find', compact('findDetInvoice', 'findInvoice','customer'))
            ->with('nameCli', $nameCli);

    }

    public function createIng($idfact,$idcli){
 
        $proofIncome = ComprobanteIngreso::where('idfact',$idfact)
                                         ->first();
        $idcom = $proofIncome->pluck('idcom');
        
        $detProof = DetComprobanteIng::where('idcom',$idcom)
                                    ->first();
        $invoice = Factura::where('idfact',$idfact)
                          ->first();
        $tipId = $invoice->tipid;
        $identification = $invoice->identificacion;
        $numCheck = $invoice->tiprif;
        $detInvoice = DetFact::where('idfact',$idfact)
                             ->first();
        $customer = Cliente::where('idcli',$idcli)
                            ->first();
        $contrCli = ContrCli::where('idcli',$idcli)
                            ->first();
        $fecRegister = Carbon::now()
                        ->format('d/m/y');
        return view('income.create',compact('proofIncome','detProof','invoice','detInvoice','customer','contrCli','fecRegister','tipId','identification','numCheck'));
    }

    public function storeIncome(Request $request){
         $idcta1 = CatgSubCuenta::select('idcta')
                                ->where('idscu', $request->get('subaccountname1'))
                                ->first();
        $idcta2 = CatgSubCuenta::where('idscu', $request->get('subaccountname2'))
                                ->first();

        $iddcomp = $request->get('iddcomp');
        $coduser = auth()->id();
        $iddfact = intval($request->get('iddfact'));
        $finalAmount = floatval($request->get('finalamount'));
        $detInvoice = DetFact::where('iddfact',$iddfact)->first();
        $proofIncome = ComprobanteIngreso::where('idfact',$detInvoice->idfact)->first();
        $amountTaxes = floatval($detInvoice->mtoimpuestolocal);
        $difIgtf = floatval($proofIncome->montoigtflocal);

        $seatAmount = new Asiento();
        $seatAmount->fec_asi = $request->get('fecIncome');
        $seatAmount->observacion = $request->get('observation');
        $seatAmount->idcta1 = $idcta1->idcta;
        $seatAmount->idcta2 = $idcta2->idcta;
        $seatAmount->descripcion = $request->get('description');
        $seatAmount->monto_deb = $finalAmount;
        $seatAmount->monto_hab = $finalAmount;
        $seatAmount->save();

        if ($amountTaxes > 0) {
            $seatTaxes = new Asiento();
            $seatTaxes->fec_asi = $request->get('fecIncome');
            $seatTaxes->observacion = $request->get('observation');
            $seatTaxes->idcta1 = 85;
            $seatTaxes->idcta2 = 85;
            $seatTaxes->descripcion = $request->get('description');
            $seatTaxes->monto_deb = $amountTaxes;
            $seatTaxes->monto_hab = $amountTaxes;
            $seatTaxes->save();
        }
        
        if ($difIgtf > 0 ) {
            $seatIgtf = new Asiento();
            $seatIgtf->fec_asi = $request->get('fecIncome');
            $seatIgtf->observacion = $request->get('observation');
            $seatIgtf->idcta1 = 88;
            $seatIgtf->idcta2 = 88;
            $seatIgtf->descripcion = $request->get('description');
            $seatIgtf->monto_deb = $difIgtf;
            $seatIgtf->monto_hab = $difIgtf;
            $seatIgtf->save();
        }
       
        

        $income  = new Ingreso();
        $income->iddcomp = $iddcomp;
        $income->idcli = $request->get('idcli');
        $income->iddfact = $iddfact;
        $income->coduser = $coduser;
        $income->idasi = $seatAmount->idasi;
        $income->concepto_ing = $request->get('description');
        $income->moneda = $request->get('money');
        $income->stsing = 'INC';
        $income->fec_ing = $request->get('fecTransiction');
        $income->save();

        $proofIncome = DetComprobanteIng::find($iddcomp);
        $proofIncome->stscom = 'INC';
        $proofIncome->save(); 
        //se pasa a inc para que no se muestre en los cobros pendientes
        $detInvoice = DetFact::find($iddfact);
        $detInvoice->stsfact = 'INC';
        $detInvoice->save();
        
        $idcli = intval($request->get('idcli'));
        $contrCli = ContrCli::where('idcli',$idcli)->first();
        $amount = floatval($contrCli->montopaglocal);
        $tip_pag = $contrCli->tip_pag;
        $findDetInvoice = Factura::join('det_facts','facturas.idfact','=','det_facts.idfact')
                                ->select('det_facts.mtolocal')
                                ->where('facturas.idcli',$idcli)
                                ->where('det_facts.stsfact','ACT')
                                ->get();
        $findDetInvoiceAux = Factura::join('det_facts','facturas.idfact','=','det_facts.idfact')
                                    ->select('det_facts.mtolocal')
                                    ->where('facturas.idcli',$idcli)
                                    ->where('det_facts.stsfact','INC')
                                    ->get();
        $valueGiros = count($findDetInvoice);
        $valueAux = count($findDetInvoiceAux);
        $totAmountGiro = $findDetInvoice->sum('mtolocal');
        if ($valueAux > 0) {
            if ($valueGiros > 0 ) {
                switch ($tip_pag) {
                    case 'MEN':
                        $totGiro = $amount / 12;
                        for ($i=0; $i < $valueGiros ; $i++) { 
                            $seatGiro = new Asiento();
                            $seatGiro->fec_asi = $request->get('fecIncome');
                            $seatGiro->observacion = $request->get('observation');
                            $seatGiro->idcta1 = 261;
                            $seatGiro->idcta2 = 123;
                            $seatGiro->descripcion = "Cuenta por cobrar a giro " . $i;
                            $seatGiro->monto_deb = $totGiro;
                            $seatGiro->monto_hab = $totAmountGiro;
                            $seatGiro->save();
                        }
                        break;
                    case 'SEM':
                        $totGiro = $amount / 2;
                        for ($i=0; $i < $valueGiros ; $i++) { 
                            $seatGiro = new Asiento();
                            $seatGiro->fec_asi = $request->get('fecIncome');
                            $seatGiro->observacion = $request->get('observation');
                            $seatGiro->idcta1 = 261;
                            $seatGiro->idcta2 = 123;
                            $seatGiro->descripcion = "Cuenta por cobrar a giro " . $i;
                            $seatGiro->monto_deb = $totGiro;
                            $seatGiro->monto_hab = $totAmountGiro;
                            $seatGiro->save();
                        }
                        break;
                    case 'TRI':
                        $totGiro = $amount / 12;
                        for ($i=0; $i < $valueGiros ; $i++) { 
                            $seatGiro = new Asiento();
                            $seatGiro->fec_asi = $request->get('fecIncome');
                            $seatGiro->observacion = $request->get('observation');
                            $seatGiro->idcta1 = 261;
                            $seatGiro->idcta2 = 123;
                            $seatGiro->descripcion = "Cuenta por cobrar a giro " . $i;
                            $seatGiro->monto_deb = $totGiro;
                            $seatGiro->monto_hab = $totAmountGiro;
                            $seatGiro->save();
                        }
                        break;
                }
            }
        }
        
        Session::flash('mensaje','se ha realizado el ingreso correctamente');
        return redirect()->route('searchIncome');
    }

    public function verifyaccount(Request $request)
    {
        if ($request->get('subaccountname1') == 'Seleccionar SubCuenta' || $request->get('subaccountname2') == 'Seleccionar SubCuenta') {
            Session::flash('error', 'Debe crear el asiento con una subCuenta');
            return redirect()->route('storeIncome');
        }

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
