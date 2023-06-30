<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factura;
use App\Models\DetFact;
use App\Models\ConceptoFact;
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
use App\Models\ComprobantePago;
use App\Models\DetalleIngreso;
use App\Models\Ingreso;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Session;

class IncomeController extends Controller
{ 
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:searchIncome')->only('searchIncome');
        $this->middleware('can:findIncome')->only('findIncome');
        $this->middleware('can:createIng')->only('createIng','storeIncome','imprreportingr','verifyaccount');
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

        $findDetInvoice = Factura::join('det_facts','facturas.idfact','=','det_facts.idfact')
                                ->select('det_facts.fec_emi','facturas.idfact','det_facts.numfact','det_facts.numctrl',
                                'det_facts.mtototallocal','det_facts.mtototalmoneda','facturas.tip_pago','facturas.moneda')
                                ->whereIn('facturas.idfact',$invoiceId)
                                ->where('det_facts.stsfact','PAG')
                                ->get(); 
        $valueDetInvoice = count($findDetInvoice);
        if ($valueDetInvoice < 1) {
            Session::flash('error','No hay giros por cobrar para este cliente');
            return redirect()->route('searchIncome');
        }

        $nameCli = Cliente::where('idcli',$customer->idcli)->get();

        return view('income.find', compact('findDetInvoice','customer'))
            ->with('nameCli', $nameCli);

    }

    public function createIng($idfact,$idcli){
        $proofIncome = ComprobanteIngreso::join('det_comprobante_ings','comprobante_ingresos.idcom','=','det_comprobante_ings.idcom')
                                         ->select('det_comprobante_ings.fec_trans','comprobante_ingresos.numconfirm','comprobante_ingresos.numfact',
                                         'det_comprobante_ings.formpago','comprobante_ingresos.mtolocal','comprobante_ingresos.mtomoneda',
                                         'det_comprobante_ings.descripcion','det_comprobante_ings.iddcomp','comprobante_ingresos.idfact','comprobante_ingresos.tasa_cambio')
                                         ->where('comprobante_ingresos.idfact',$idfact)
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
                        ->format('Y-m-d');
        return view('income.create',compact('proofIncome','invoice','detInvoice','customer','contrCli','fecRegister','tipId','identification','numCheck'));
    }

    public function storeIncome(Request $request){
        $this->validate($request, [
            'numconfirm' => 'required',
            'byconcept' => 'required',
            'description' => 'required',
            'descriptioni' => 'required',
            'observation' => 'required',
        ]);
         $idcta1 = CatgSubCuenta::select('idcta')
                                ->where('idscu', $request->get('subaccountname1'))
                                ->first();
        $idcta2 = CatgSubCuenta::where('idscu', $request->get('subaccountname2'))
                                ->first();
        $iddcomp = $request->get('iddcomp');
        $coduser = auth()->id();
        $iddfact = intval($request->get('iddfact'));
        $customer = Cliente::find(intval($request->get('idcli')));
        //para sacar el monto del asiento
        $finalAmount = floatval($request->get('montoasiento'));
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
        $seatAmount->monto_deb = floatval($detInvoice->mtoimponiblelocal);
        $seatAmount->monto_hab = floatval($detInvoice->mtoimponiblelocal);
        $seatAmount->save();

        if ($amountTaxes > 0) {
            $seatTaxes = new Asiento();
            $seatTaxes->fec_asi = $request->get('fecIncome');
            $seatTaxes->observacion = "Retencion por pagar por ingreso de " . $customer->nombre;
            $seatTaxes->idcta1 = 35; 
            $seatTaxes->idcta2 = 84;
            $seatTaxes->descripcion = "Retencion por pagar por ingreso de " . $customer->nombre;
            $seatTaxes->monto_deb = $amountTaxes * 0.75;
            $seatTaxes->monto_hab = $amountTaxes * 0.75;
            $seatTaxes->save();
        }
        if ($difIgtf > 0 ) {
            $seatIgtf = new Asiento();
            $seatIgtf->fec_asi = $request->get('fecIncome');
            $seatIgtf->observacion = "Gastos de I.G.T.F por ingreso de " . $customer->nombre;
            $seatIgtf->idcta1 = 259;
            $seatIgtf->idcta2 = $idcta1->idcta;
            $seatIgtf->descripcion = "Gastos de I.G.T.F por ingreso de " . $customer->nombre;
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
        $income->concepto_ing = $request->get('descriptioni');
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
        

        $contrCli = ContrCli::where('idcli',intval($request->get('idcli')))->first();

        $amount = floatval($contrCli->montopaglocal);
        $tip_pag = $contrCli->tip_pag;


        $findDetInvoice = Factura::join('det_facts','facturas.idfact','=','det_facts.idfact')
                                ->select('det_facts.mtolocal')
                                ->where('facturas.idcli',intval($request->get('idcli')))
                                ->where('det_facts.stsfact','ACT')
                                ->get();
        $findDetInvoiceAux = Factura::join('det_facts','facturas.idfact','=','det_facts.idfact')
                                    ->select('det_facts.mtolocal')
                                    ->where('facturas.idcli',intval($request->get('idcli')))
                                    ->where('det_facts.stsfact','INC')
                                    ->get();


        /* $valueGiros = count($findDetInvoice);
        $valueAux = count($findDetInvoiceAux);
        $totAmountGiro = $findDetInvoice->sum('mtolocal');
        if ($contrCli->ind_girosre == 'S'){
            if ( $valueAux > 0 && $valueGiros > 0) {
                switch ($tip_pag) {
                    case 'MEN':
                        $totGiro = $amount / 12;
                        for ($i=0; $i < $valueGiros  ; $i++) { 
                            $seatGiro = new Asiento();
                            $seatGiro->fec_asi = $request->get('fecIncome');
                            $seatGiro->observacion = $request->get('observation');
                            $seatGiro->idcta1 = 261;
                            $seatGiro->idcta2 = 123;
                            $seatGiro->descripcion = "Cuenta por cobrar a giro " . $i;
                            $seatGiro->monto_deb = $totGiro;
                            $seatGiro->monto_hab = 0;
                            $seatGiro->save();
                        }
                        $seatGiro = new Asiento();
                        $seatGiro->fec_asi = $request->get('fecIncome');
                        $seatGiro->observacion = $request->get('observation');
                        $seatGiro->idcta1 = 261;
                        $seatGiro->idcta2 = 123;
                        $seatGiro->descripcion = "Cuenta por cobrar a giro 12";
                        $seatGiro->monto_deb = $totGiro;
                        $seatGiro->monto_hab = $totAmountGiro;
                        $seatGiro->save();
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
                        $totGiro = $amount / 3;
                        for ($i=0; $i < $valueGiros  ; $i++) { 
                            $seatGiro = new Asiento();
                            $seatGiro->fec_asi = $request->get('fecIncome');
                            $seatGiro->observacion = $request->get('observation');
                            $seatGiro->idcta1 = 261;
                            $seatGiro->idcta2 = 123;
                            $seatGiro->descripcion = "Cuenta por cobrar a giro " . $i;
                            $seatGiro->monto_deb = $totGiro;
                            $seatGiro->monto_hab = 0;
                            $seatGiro->save();
                        }

                        $seatGiro = new Asiento();
                        $seatGiro->fec_asi = $request->get('fecIncome');
                        $seatGiro->observacion = $request->get('observation');
                        $seatGiro->idcta1 = 261;
                        $seatGiro->idcta2 = 123;
                        $seatGiro->descripcion = "Cuenta por cobrar a giro 3";
                        $seatGiro->monto_deb = $totGiro;
                        $seatGiro->monto_hab = $totAmountGiro;
                        $seatGiro->save();
                        break;
                }
            }
        } */
        $idfact = intval($detInvoice->idfact);
        $idcom = intval($proofIncome->idcom);
        
        Session::flash('mensaje','se ha realizado el ingreso correctamente');
        return redirect()->route('imprIncome',['idfact' => $idfact, 'idcli' => intval($request->get('idcli')), 'idcom' => $idcom]);
    }

    public function imprIncome($idfact,$idcli,$idcom){
        $income = Ingreso::orderBy('iding','desc')->first();
      
        $customer = Cliente::find($idcli);
        $detInvoice = DetFact::where('idfact',$idfact)->first();
        
        $proofIncome = ComprobanteIngreso::find($idcom);


        return view('income.total',compact('income','customer','detInvoice','proofIncome','idfact','idcli','idcom'));
    }

    public function imprreportingr($idfact, $idcli,$idcom){
        // ...
        $income = Ingreso::orderBy('iding','desc')->first();
        $detProofIncome = ComprobanteIngreso::join('det_comprobante_ings','comprobante_ingresos.idcom','=','det_comprobante_ings.idcom')
                                        ->select('comprobante_ingresos.mtolocal','comprobante_ingresos.mtomoneda','det_comprobante_ings.fec_trans','comprobante_ingresos.idfact')
                                        ->where('det_comprobante_ings.idcli',$idcli)
                                        ->where('det_comprobante_ings.stscom','INC')
                                        ->orderBy('det_comprobante_ings.fec_trans','asc')
                                        ->get();
                                       
        $sumIng = ComprobanteIngreso::join('det_comprobante_ings','comprobante_ingresos.idcom','=','det_comprobante_ings.idcom')
                                        ->select('comprobante_ingresos.mtolocal','comprobante_ingresos.mtomoneda','det_comprobante_ings.fec_trans','comprobante_ingresos.idfact')
                                        ->where('det_comprobante_ings.idcli',$idcli)
                                        ->where('det_comprobante_ings.stscom','INC')
                                        ->orderBy('det_comprobante_ings.fec_trans','asc')
                                        ->sum('comprobante_ingresos.mtolocal');
        $idfact = $detProofIncome->pluck('idfact')->values();
        $fecini = DetComprobanteIng::where('idcli',$idcli)
                                    ->where('stscom','INC')
                                    ->orderBy('fec_trans','asc')
                                    ->first();
                                   
        $fecfin = DetComprobanteIng::where('idcli',$idcli)
                                    ->where('stscom','INC')
                                    ->orderBy('fec_trans','desc')
                                    ->first();
                                   
        $numreling = ConceptoFact::join('facturas','concepto_facts.idcfact','=','facturas.idcfact')                        
                            ->select('concepto_facts.num_ing')
                            ->whereIn('facturas.idfact',$idfact)
                            ->get();

                           
        $customer = Cliente::where('idcli', intval($idcli))->first();
        $imagePath = storage_path("img/logo.png");
        $image = base64_encode(file_get_contents($imagePath));
        
        $options = new Options();
        $options->set('isRemoteEnabled', true); // Permite cargar imágenes desde URL
        $options->set('defaultFont', 'Arial'); // Fuente predeterminada
        $options->set('orientation', 'landscape'); // Orientación horizontal
        $options->set('size', 'letter'); // Tamaño de página: carta (letter)

        $dompdf = new Dompdf($options);

        $view = view('income.relingpdf', compact('customer','sumIng', 'fecini','fecfin','numreling', 'detProofIncome', 'image'))->render();
        $dompdf->loadHtml($view);
        $dompdf->render();

        return $dompdf->stream('Ingresos_por_cliente.pdf');
    }

    public function verifyaccount(Request $request){
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
