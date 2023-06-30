<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoriaProveedor;
use App\Models\ComprobantePago;
use App\Models\DetalleComprobantePago;
use App\Models\Proveedor;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\Paginator;
class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:supplier.index')->only('index');
        $this->middleware('can:supplier.create')->only('create','store');
        $this->middleware('can:supplier.edit')->only('edit','update');
        $this->middleware('can:supplier.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $registerSupplier = Proveedor::select('idprov','nombre','tipid','identificacion','tiprif','telefono','direccion','categoria')
                                     ->orderBy('nombre','asc')
                                     ->paginate(10);
        $tipCategory = CategoriaProveedor::all();
        return view('supplier.index',compact('registerSupplier','tipCategory'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipSupplier = CategoriaProveedor::orderBy('descripcion','asc')
                                            ->get();
        return view('supplier.create',compact('tipSupplier'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

        $this->validate($request,[
            
            'name' => 'required|regex:/^[A-Z][A-Z,a-z, ,á,é,í,ó,ú]+$/',
            'tipid' => 'required',
            'identification' => 'required|numeric',
            'phone' => 'required',
            'direction'=>'required', 
            'email' =>'required|email',
            'category' => 'required',

        ]);
        if ($request->get('reten') == 'S' && $request->get('porcreten') == null) {
            Session::flash('error','debe seleccionar el porcentaje retenido');
            return redirect()->action([SupplierController::class, 'create']);

        }
        $porcreten = intval($request->get('porcreten'));
        $porcreten = $porcreten / 100;

        $supplier = new Proveedor();
        $supplier->nombre = $request->get('name');
        $supplier->tipid = $request->get('tipid');
        $supplier->identificacion = $request->get('identification');
        if ($request->get('tiprif')== "Seleccionar Numero"){
            $supplier->tiprif = null;
        }
        else{
            $supplier->tiprif = $request->get('tiprif'); 
        }
        $supplier->direccion = $request->get('direction');
        $supplier->telefono = $request->get('phone');
        $supplier->correo = $request->get('email');
        $supplier->categoria = $request->get('category');
        $supplier->indcontribuyente = $request->get('reten');
        $supplier->porcentajereten = $porcreten;
        $supplier->save();
        Session::flash('message','se ha creado el proveedor correctamente');
        return redirect('/supplier');
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
    public function edit($id)
    {
        $supplier = Proveedor::find($id);
        $categorySupplier = $supplier->pluck('categoria')->values()->first();
        $tiprif = $supplier->pluck('tiprif')->values()->first();
        if ($tiprif == 'J') {
            $indTiprif = 'S';
        }else{
            $indTiprif = 'N';
        }
        $tipSupplier = CategoriaProveedor::orderBy('descripcion')->get();
        $tipProve = $tipSupplier->pluck('tip_prove');

        $tipCategory = null; // Variable para almacenar el valor de tip_prove

        if ($tipProve->contains($categorySupplier)) {
            $tipCategory = $tipSupplier->where('tip_prove', $categorySupplier)->first()->descripcion;
        }
        
        Session::flash('message','se ha modificado el proveedor correctamente');
        return view('supplier.edit',compact('supplier','tipSupplier','tipCategory','categorySupplier','indTiprif'));
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
        $supplier = Proveedor::find($id);
        $supplier->nombre = $request->get('name');
        $supplier->tipid = $request->get('tipid');
        $supplier->identificacion = $request->get('identification');
        if ($request->get('tiprif')== "Seleccionar Numero"){
            $supplier->tiprif = null;
        }
        else{
            $supplier->tiprif = $request->get('tiprif'); 
        }
        $supplier->direccion = $request->get('direction');
        $supplier->telefono = $request->get('phone');
        $supplier->correo = $request->get('email');
        $supplier->categoria = $request->get('category');
        $supplier->save();
        return redirect('/supplier');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pay = DetalleComprobantePago::where('idprov',$id)->get();
        if (count($pay) > 0 ) {
            Session::flash('error','Existen registros contables de este proveedor, no se puede borrar');
            return redirect('/supplier');
        } else {
            $supplier = Proveedor::find($id);
            $supplier->delete();
            return redirect('/supplier');
        }  
    }
}
