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
use App\Models\Ingreso;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class IncomeController extends Controller
{
    public function searchIncome(){
        return view('income.search');
    }
    
    public function findIncome(Request $request){
        $tipId = $request->get('tipid');
        $identification = $request->get('identification');
        $numCheck = $request->get('numcheck');
        if ($numCheck == 'Seleccionar Numero') {
            $numCheck = null;
        }
        $findInvoice = Factura::where('tipid',$tipId)   
                              ->where('identificacion',$identification)
                              ->where('tiprif',$numCheck)
                              ->get();
                              //dd($findInvoice);
        $invoiceId = $findInvoice->pluck('idfact');
        
        $findDetInvoice = DetFact::whereIn('idfact', $invoiceId)
                                   ->where('stsfact','PAG')
                                   ->get();  
        $nameCli =  Cliente::select('idcli','nombre')
                           ->where('identificacion',$identification)
                           ->get();
        return view('income.find',compact('findDetInvoice','findInvoice'))
                    ->with('nameCli',$nameCli[0]);
       /*  ->with('findInvoice',$findInvoice)
        ->with('findDetInvoice',$findDetInvoice);//,compact('findDetInvoice','findInvoice')); */
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
        $seat = new Asiento();
        $seat->fec_asi = $request->get('fecIncome');
        $seat->observacion = $request->get('observartion');
        $seat->idcta1 = $idcta1->idcta;
        $seat->idcta2 = $idcta2->idcta;
        $seat->descripcion = $request->get('description');
        $seat->monto_deb = $request->get('amount');
        $seat->monto_hab = $request->get('amount');
        $seat->save();

        $income  = new Ingreso();
        $income->iddcomp = $iddcomp;
        $income->idcli = $request->get('idcli');
        $income->iddfact = $request->get('iddfact');
        $income->coduser = $coduser;
        $income->idasi = $seat->idasi;
        $income->concepto_ing = $request->get('description');
        $income->moneda = $request->get('money');
        $income->stsing = 'INC';
        $income->fec_ing = $request->get('fecTransiction');
        $income->save();

        $proofIncome = DetComprobanteIng::find($iddcomp);
        $proofIncome->stscom = 'INC';
        $proofIncome->save();
        Session::flash('mensaje','se ha realizado el ingreso correctamente');
        return redirect()->route('searchIncome');
        


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
