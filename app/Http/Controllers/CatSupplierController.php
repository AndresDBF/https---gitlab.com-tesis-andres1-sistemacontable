<?php

namespace App\Http\Controllers;

use App\Models\CategoriaProveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\Paginator;

class CatSupplierController extends Controller
{
    public function index()
    {
        $catSupplier = CategoriaProveedor::orderBy('id','asc')
                                        ->paginate(5);
        return view('supplier.categories.index',compact('catSupplier'));
    }
    public function create()
    {
        return view('supplier.categories.create');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'abrecat' => 'required|size:3|alpha',
            'namecat' => 'required'
        ], [
            'abrecat.required' => 'El campo abrecat es obligatorio.',
            'abrecat.size' => 'El campo abrecat debe tener 3 caracteres.',
            'abrecat.alpha' => 'El campo abrecat solo debe contener letras.',
        ]);

        $catSupplier = CategoriaProveedor::all();
        $abrecat = strtoupper($request->get('abrecat'));
       
        foreach ($catSupplier as $cat) {
            if ($cat->tip_prove == $abrecat) {
               
                Session::flash('error','La abrebiatura ya existe');
                return redirect()->route('catsupplier.create');
            }
        }

        $categorie = new CategoriaProveedor();
        $categorie->tip_prove = $abrecat;
        $categorie->descripcion = $request->get('namecat');
        $categorie->save();
        Session::flash('message','Se ha Creado la Categoria Correctamente');
        return redirect('/catsupplier');


    }
    public function edit($id)
    {
        $catSupplier = CategoriaProveedor::find($id);

        return view('supplier.categories.edit',compact('catSupplier'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'abrecat' => 'required|size:3|alpha',
            'namecat' => 'required'
        ], [
            'abrecat.required' => 'El campo abrecat es obligatorio.',
            'abrecat.size' => 'El campo abrecat debe tener 3 caracteres.',
            'abrecat.alpha' => 'El campo abrecat solo debe contener letras.',
        ]);

        $tip_prove = CategoriaProveedor::find($id);
        $catSupplier = CategoriaProveedor::all();
        $abrecat = strtoupper($request->get('abrecat'));
       
        if ($tip_prove->tip_prove != $abrecat) {
            foreach ($catSupplier as $cat) {
                if ($cat->tip_prove == $abrecat) {
                   
                    Session::flash('error','La abrebiatura ya existe');
                    return redirect()->route('catsupplier.create');
                }
            }
        }
        CategoriaProveedor::where('id',$id)->update([
            'tip_prove' => $abrecat,
            'descripcion' => $request->get('namecat')
        ]);

        Session::flash('message','Se ha Actualizado la Categoria Correctamente');
        return redirect('/catsupplier');
    }
}
