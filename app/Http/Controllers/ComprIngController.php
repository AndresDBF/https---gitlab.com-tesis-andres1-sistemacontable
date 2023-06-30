<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factura;
use App\Models\DetFact;
use App\Models\ConceptoFact;
use App\Models\Cliente;
use App\Models\Moneda;
use App\Models\TipPago;
use App\Models\DetComprobanteIng;
use App\Models\ComprobanteIngreso;
use Illuminate\Support\Facades\Session;

use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;

class ComprIngController extends Controller
{
    public function __construct()
    {
        //utilizado para restriccion de rutas
        $this->middleware('auth');
        $this->middleware('can:searchInvoice')->only('searchInvoice'); //solo se aplicara al metodo index
        $this->middleware('can:findInvoice')->only('findInvoice');
        $this->middleware('can:createIncome')
             ->only('createIncome','storeproof','totalproof','convertToPdf','deleteproof');
    }
    
    public function searchInvoice(){
        $customer = Cliente::join('contr_clis','clientes.idcli','=','contr_clis.idcli')
        ->select('clientes.idcli','clientes.nombre','clientes.tipid','clientes.identificacion','clientes.tiprif','clientes.telefono', 
        'clientes.email','contr_clis.stscontr','contr_clis.tip_pag')
        ->orderBy('clientes.nombre')
        ->get();
        return view("proof.find",compact('customer'));
    }

    public function findInvoice(Request $request){
        $identification = $request->get('customer');
        $nameCli = Cliente::select('idcli', 'nombre', 'tipid','identificacion', 'tiprif')
            ->where('identificacion', $identification)
            ->first();
    
        $findInvoice = Factura::where('idcli', $nameCli->idcli)->get();
        $invoiceId = $findInvoice->pluck('idfact');
        $findDetInvoice = Factura::join('det_facts','facturas.idfact','=','det_facts.idfact')
                                ->select('det_facts.fec_emi','facturas.idfact','det_facts.numfact','det_facts.numctrl',
                                'det_facts.mtototallocal','det_facts.mtototalmoneda','facturas.tip_pago','facturas.moneda')
                                ->whereIn('facturas.idfact',$invoiceId)
                                ->where('det_facts.stsfact','ACT')
                                ->get();   
                                 
        $customer = Cliente::where('identificacion', $identification)->get();
    
        $valueInvoice = count($findInvoice);
        $valueCli = count($customer);
        $countInvoice = count($findDetInvoice);
        if ($countInvoice > 0) {
            if ($valueCli > 0 && $valueInvoice > 0) {
                return view('proof.proofincome', compact('findDetInvoice', 'findInvoice', 'customer'))
                    ->with('nameCli', $nameCli);
            } else {
                Session::flash('error', "No se han encontrado Facturas con esta Identificacion");
                return redirect()->route('searchInvoice');
            }
        } else {
            Session::flash('error', "No hay facturas pendientes para este cliente");
            return redirect()->route('searchInvoice');
        }
    }
    

    public function createIncome($idfact,$idcli){

        $valueIdfact = $idfact;
        $valueIdcli = $idcli;
        $invoice = Factura::where('idfact',$valueIdfact)
                          ->first();  
        $nameCli = Cliente::where('idcli',$idcli)->first();
        $fecTransaction =  Carbon::now()->format('Y-m-d');
        $detInvoice = DetFact::where('idfact',$valueIdfact)
                             ->first();
        $money = Moneda::all();
        $formPay = TipPago::where('tip_proceso','ingresos_gastos')
                          ->orderBy('descripcion')
                          ->get();
        return view('proof.create',compact('invoice','fecTransaction','nameCli','detInvoice','money','formPay','valueIdfact','valueIdcli'));
    }

    public function storeproof(Request $request){
        $idcli = intval($request->get('idcli'));
        $idfact = intval($request->get('idfact'));
        if (strlen($request->get('money')) > 3 ) {
            Session::flash('error','Realice la seleccion de moneda');
            return redirect()->route('createIncome',['idfact' => $idfact,'idcli'=>$idcli]);
        }
        elseif(strlen($request->get('formPay')) > 3){
            Session::flash('error','Realice la seleccion de pago');
            return redirect()->route('createIncome',['idfact' => $idfact,'idcli'=>$idcli]);
        }

        $proofIncome = new ComprobanteIngreso();
        $proofIncome->idfact = $idfact;
        $proofIncome->numconfirm = $request->get('numconfirm');
        $proofIncome->numfact = $request->get('numfact');
        $proofIncome->moneda = $request->get('money');
        $tasa_cambio = floatval($request->get('tasa_cambio'));
        if ($request->get('money') != 'BS') {
            $amount = $request->get('amount'); 
            $increment = $amount * 0.03; 
            $totalAmount = $amount + $increment;
            $proofIncome->mtolocal = $totalAmount * $tasa_cambio;
            $proofIncome->mtomoneda = $totalAmount;
            $proofIncome->tasa_cambio = $tasa_cambio;
            $proofIncome->montoigtflocal = $increment * $tasa_cambio;
            $proofIncome->montoigtfmoneda = $increment;
        }else {
            $amount = $request->get('amount'); 
            $proofIncome->mtolocal = 0;
            $proofIncome->mtomoneda = $amount;
            $proofIncome->tasa_cambio = $tasa_cambio;
        }

        $proofIncome->cantidad_escr = $request->get('byconcept');
        $proofIncome->save();

        $detProofIncome = new DetComprobanteIng();
        $detProofIncome->idcom = $proofIncome->idcom;
        $detProofIncome->idcli = $idcli;
        $detProofIncome->nombre_cliente = $request->get('name');
        $detProofIncome->fec_trans = $request->get('fecTransiction');
        $detProofIncome->stscom = 'ACT';
        $detProofIncome->formpago = $request->get('formPay');
        $detProofIncome->descripcion = $request->get('description');
        $detProofIncome->save(); 
        $idfact = intval($request->get('idfact'));
        DetFact::where('idfact',$idfact)->update([
            'stsfact' => 'PAG'
        ]);
        Session::flash('successProof','se ha realizado el comprobante de ingreso Correctamente');
            return redirect()->route('totalproof',$proofIncome->idcom);
    }    

    public function totalproof($idcom){
        $proofIncome = ComprobanteIngreso::find($idcom);
        $detProofIncome = DetComprobanteIng::where('idcom',$idcom)->first();
        $customer = Cliente::where('idcli',intval($detProofIncome->idcli))->first();
        $idcom = intval($proofIncome->idcom);
        $idcli = intval($customer->idcli);
        return view('proof.total',compact('proofIncome','detProofIncome','customer','idcli','idcom'));
    }

    public function convertToPdf($idcom, $idcli){
        // ...

        $proofIncome = ComprobanteIngreso::find($idcom);
        $detProofIncome = DetComprobanteIng::where('idcom', $idcom)->first();
        $customer = Cliente::where('idcli', intval($detProofIncome->idcli))->first();
        $imagePath = storage_path("img/logo.png");
        $image = base64_encode(file_get_contents($imagePath));

        $options = new Options();
        $options->set('isRemoteEnabled', true); // Permite cargar imágenes desde URL
        $options->set('defaultFont', 'Arial'); // Fuente predeterminada
        $options->set('orientation', 'landscape'); // Orientación horizontal
        $options->set('size', 'letter'); // Tamaño de página: carta (letter)

        $dompdf = new Dompdf($options);

        $view = view('proof.proofpdf', compact('customer', 'proofIncome', 'detProofIncome', 'image'))->render();
        $dompdf->loadHtml($view);
        $dompdf->render();

        return $dompdf->stream('recibo.pdf');
    }

    public function deleteproof($idcom){
       
        $detProofIncome = DetComprobanteIng::where('idcom',$idcom)->delete();
        $proofIncome = ComprobanteIngreso::find($idcom)->delete();
        return redirect()->route('searchInvoice');
    }
}

