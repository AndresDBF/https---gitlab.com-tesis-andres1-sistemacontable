<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\ContrCli;
use App\Models\CatCuenta;
use App\Models\ReglaStatus;
use App\Models\Moneda;
use App\Models\CatGrupo;
use App\Models\CatSubGru;
use App\Models\CatgCuenta;
use App\Models\CatgSubCuenta;
use App\Models\TipPago;
use App\Models\Asiento;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\Paginator;
/* use App\Models\Tipocuenta;
use App\Models\Tipomovimiento; 
use App\Models\Nombrecuenta; */


class CustomerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer = Cliente::join('contr_clis','clientes.idcli','=','contr_clis.idcli')
        ->select('contr_clis.idasi','clientes.idcli','clientes.nombre','clientes.tipid','clientes.identificacion','clientes.tiprif','clientes.telefono',
        'clientes.email','contr_clis.stscontr','contr_clis.tip_pag')
        ->orderBy('clientes.nombre')
        ->paginate(10);
        
        return view('clientes.index')
             ->with('customer',$customer);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
            $consulta = Cliente::orderBy('idcli','desc')
                               ->take(1)
                               ->get();
                               
            $cuantos = count($consulta);
            if ($cuantos == 0){
                $idesigue = 1;
    
            }
            else{
                $idesigue = $consulta[0]->idcli+1;
            }
            /* $accounts = CatCuenta::orderBy('tipcta')
                                 ->get(); */
            $tippag = TipPago::where('tip_proceso','contr_cli')
                             ->orderBy('descripcion')
                             ->get();
            $money = Moneda::all();
            $status = ReglaStatus::where('tipsts','contrato')
                                 ->get();
                                
        return view('clientes/create')
                ->with('idsigue',$idesigue)
                ->with('tippag',$tippag)
                ->with('money',$money)
                ->with('status',$status);
                

                /* $last2 = DB::table('items')->orderBy('id', 'DESC')->first(); */
                
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            
            'name' => 'required|regex:/^[A-Z][A-Z,a-z, ,á,é,í,ó,ú]+$/',
            'tipid' => 'required',
            'identification' => 'required|numeric',
            'phone' => 'required',
            'direction'=>'required', 
            'email' =>'required|email',
            'stscontr' => 'required|in:ACT',
            'tip_pag' => 'required',
            'valuecont' => 'required',
            'money' => 'required'
        ]);

        $idcta1 = CatgSubCuenta::select('idcta')
                                ->where('idscu', $request->get('subaccountname1'))
                                ->first();
        $idcta2 = CatgSubCuenta::where('idscu', $request->get('subaccountname2'))
                                ->first();
        $seat = new Asiento();
        $seat->fec_asi = Carbon::now();
        $seat->observacion = $request->get('observartion');
        $seat->idcta1 = $idcta1->idcta;
        $seat->idcta2 = $idcta2->idcta;
        $seat->descripcion = $request->get('description');
        if ($request->get('money') == 'USD' || $request->get('money') == 'EUR'){
            $seat->monto_deb = - ($request->get('valuecont') * $request->get('tasa_cambio'));
        }
        elseif ($request->get('money') == 'COP'){
            $seat->monto_deb = - ($request->get('valuecont') / $request->get('tasa_cambio'));
        }
        elseif ($request->get('money') == 'BS') {
            $seat->monto_deb = - $request->get('valuecont');
        }
        
        $seat->monto_hab = 0;
        $seat->save();

        $customer = new Cliente();
        $customer->idcli = $request->code;
        $customer->nombre = $request->get('name');
        $customer->tipid = $request->get('tipid');
        $customer->identificacion = $request->get('identification');
        if ($request->get('tiprif')== "Seleccionar Numero"){
            $customer->tiprif = null;
        }
        else{
            $customer->tiprif = $request->get('tiprif'); 
        }
        $customer->telefono = $request->get('phone');
        $customer->email = $request->get('email');
        $customer->direccion = $request->get('direction');
        $customer->save();
 
        $contrCustomer = new ContrCli();
        $contrCustomer->idcli = $customer->idcli;
        $contrCustomer->stscontr = $request->get('stscontr');
        $contrCustomer->tip_pag = $request->get('tip_pag');
        
        if ($request->get('money') == 'USD' || $request->get('money') == 'EUR') {
            $contrCustomer->montopaglocal = $request->get('valuecont') * $request->get('tasa_cambio');
            $contrCustomer->montopagmoneda = $request->get('valuecont');
        }
        elseif ($request->get('money') == 'COP' ) {
            $contrCustomer->montopaglocal = $request->get('valuecont') / $request->get('tasa_cambio');
            $contrCustomer->montopagmoneda = $request->get('valuecont');
        }
        elseif ($request->get('money') != 'BS'){
            $contrCustomer->montopaglocal = 0;
            $contrCustomer->montopagmoneda = $request->get('valuecont');
        }
        $contrCustomer->moneda = $request->get('money');
        $contrCustomer->idasi = $seat->idasi;
        $contrCustomer->save();
                       
        Session::flash('mensaje',"Se ha registrado el Cliente $customer->nombre correctamente");
        return redirect('/clientes');
             
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($idcli)
    {        
        
        $customer = Cliente::find($idcli);
        $contrCli = ContrCli::where('idcli',$customer->idcli)->first();
        $tippag = TipPago::where('tip_proceso','contr_cli')
                         ->get();
        $money = Moneda::all();
        $status = ReglaStatus::where('tipsts','contrato')
                             ->get();

        return view('clientes.edit',compact('customer','tippag','money','status','contrCli'));        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $customer = Cliente::find($id);
        $customer->nombre = $request->get('name');
        $customer->tipid = $request->get('tipid');
        $customer->identificacion = $request->get('identification');
        if ($request->get('tipid') != 'J') {
            $customer->tiprif = null;
        }
        else{
            $customer->tiprif = $request->get('tiprif');
        }
        $customer->telefono = $request->get('phone');
        $customer->email = $request->get('email');
        $customer->direccion = $request->get('direction');
        $customer->save();

        ContrCli::where('idcli',$id)->update([
            'stscontr' => $request->get('stscontr'),
            'tip_pag' => $request->get('tip_pag')
        ]);
       
        return redirect('/clientes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($idcli)
    {

        $contrcli = ContrCli::where('idcli',$idcli);
        $contrcli->delete();
        $cliente = Cliente::where('idcli',$idcli);
        $cliente->delete();
        
        return redirect('/clientes');
    }
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
