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
        ->select('contr_clis.idcta','clientes.idcli','clientes.nombre','clientes.rif_cedula','clientes.telefono',
        'clientes.email','contr_clis.stscontr','contr_clis.tip_pag')
        ->orderBy('clientes.nombre')
        ->get();
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
            $tippag = TipPago::orderBy('descripcion')
                             ->get();
            $money = Moneda::all();
            $status = ReglaStatus::all();
                    
            
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
        
        $customer = new Cliente();
        $customer->idcli = $request->code;
        $customer->nombre = $request->get('name');
        $customer->rif_cedula = $request->get('identification');
        $customer->telefono = $request->get('phone');
        $customer->email = $request->get('email');
        $customer->direccion = $request->get('direction');
        $customer->save();
 
        $contrCustomer = new ContrCli();
        $contrCustomer->idcli = $customer->idcli;
        $contrCustomer->stscontr = $request->get('stscontr');
        $contrCustomer->tip_pag = $request->get('tip_pag');
        $contrCustomer->monto_pag = $request->get('valuecont');
        $contrCustomer->moneda = $request->get('money');
        $contrCustomer->idcta = "12";
        $contrCustomer->save();
        $seat = new Asiento();
        $consulta = Asiento::orderBy('idasi','desc')
                               ->take(1)
                               ->get();
                               
            $cuantos = count($consulta);
            if ($cuantos == 0){
                $idesigue = 1;
    
            }
            else{
                $idesigue = $consulta[0]->idasi+1;
            }
        $seat->idasi = $idesigue;
        $seat->fec_asi = Carbon::now();
        $seat->observacion = $request->get('observartion');
        $seat->idcta = "12";
        $seat->descripcion = $request->get('description');
        $seat->monto_deb = $request->get('valuecont');
        $seat->monto_hab = $request->get('valuecont');
        $seat->save();

        /* if($request->get('subaccountname')){
            $value4 = CatgSubCuenta::select('idcta')
                                    ->where('idscu',$request->get('subaccountname'))
                                    ->get();
            $contrCustomer->idcta = 
        } */
                                 
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
        
        $dateCustom = Cliente::join('contr_clis','clientes.idcli','=','contr_clis.idcli')
                             ->select('clientes.idcli','clientes.nombre','clientes.rif_cedula','clientes.telefono','clientes.email',
                                      'clientes.direccion','contr_clis.stscontr','contr_clis.tip_pag','contr_clis.monto_pag','contr_clis.moneda',
                                      'contr_clis.idcta')
                             ->where('clientes.idcli',$idcli)
                             ->get();   
                             
        $accounts = CatCuenta::join('contr_clis','contr_clis.idcta','=','cat_cuentas.idcta')
                             ->select('cat_cuentas.idcta','cat_cuentas.tipcta','cat_cuentas.tipmov','cat_cuentas.nombre_cuenta')
                             ->whereNotIn('contr_clis.idcli',$idcli)
                             ->get();
                             

        $accounttip = CatCuenta::join('contr_clis','contr_clis.idcta','=','cat_cuentas.idcta')
                                ->select('cat_cuentas.idcta','cat_cuentas.tipcta')
                                ->distinct()
                                ->whereNotIn('cat_cuentas.tipcta',[$idcli->idcta])
                                ->get();
        $accountList = CatCuenta::WhereNotIn('idcta',$accounts)                   
                                ->get();
                                
        /* if ($accounts->tipcta = 'Activo') {
            
            $accounts = CatCuenta::join('contr_clis','contr_clis.idcta','=','cat_cuentas.idcta')
                             ->select('cat_cuentas.idcta','cat_cuentas.tipcta','cat_cuentas.tipmov','cat_cuentas.nombre_cuenta')
                             ->distinct()
                             ->get();  
                             dd($accounts);
                             
        }         */    
        $status = ReglaStatus::where('nomtabla','contr_clis')
                                ->WhereNotIn('sts',$dateCustom)
                                ->get();         
       /*  $methodpag = lvalue::where('tipvalue','tippago')
                            ->get();

        $money = lvalue::where('tipvalue','moneda')
                        ->get(); */
        
        return view('clientes.edit')
             ->with('datecustom',$dateCustom[0])
             ->with('accounts',$accounts[0])
             ->with('accountlist',$accountList)
             ->with('status',$status);
             /* ->with('money',$money)
             ->with('methodpag',$methodpag); */
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

        $customer = Cliente::find($request->idcli);

        $customer->nombre = $request->get('name');
        $customer->rif_cedula = $request->get('identification');
        $customer->telefono = $request->get('phone');
        $customer->email = $request->get('email');
        $customer->direccion = $request->get('direction');
        $customer->save();

        $contrCustomer = ContrCli::find($id);
        $contrCustomer->stscontr = $request->get('stscontr');
        $contrCustomer->tip_pag = $request->get('tip_pag');
        $contrCustomer->monto_pag = $request->get('valuecont');
        $contrCustomer->moneda = $request->get('money');
        $contrCustomer->idcta = $request->get('account');
        $contrCustomer->save();

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
    public function groupaccount()
    {
        return CatGrupo::all();
    }
    public function subgroupaccount(Request $request)
    {
        return CatSubGru::where("idgru",$request->idgru)->get();
    }
    public function accountname(Request $request)
    {
        return CatgCuenta::where("idsgr",$request->idsgr)->get();
    }
    public function subaccountname(Request $request)
    {
        return CatgSubCuenta::where('idgcu',$request->idgcu)->get();
    }
}
