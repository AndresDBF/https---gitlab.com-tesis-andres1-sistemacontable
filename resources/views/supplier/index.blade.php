@extends('adminlte::page')

@section('title', 'Proveedores')

@section('content_header')
    <h1>Registro de Proveedores</h1>
@stop

@section('content')
   
    <a href="supplier/create" class="btn btn-primary mb-3">CREAR</a>
    <table id="clientes" class="table table-striped table-bordered shadow-lg mt-4" style="width: 100%">

        <thead class="bd-primary text-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Identificación</th>
                <th scope="col">Telefono</th>
                <th scope="col">Dirección</th>
                <th scope="col">Categoria</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($registerSupplier as $supplier)
                <tr>
                    <th>{{$supplier->idprov}}</th>
                    <th>{{$supplier->nombre}}</th>
                    <th>{{$supplier->identificacion}}</th>
                    <th>{{$supplier->telefono}}</th>
                    <th>{{$supplier->direccion}}</th>
                    @foreach ($tipCategory as $tip)
                        @if ($supplier->categoria == $tip->tip_prove)
                            <th>{{$tip->descripcion}}</th>
                        @endif
                    @endforeach
                    <td>
                        <a href="/supplier/{{$supplier->idprov}}/edit" class="btn btn-info">Editar</a>
                        <form action="{{route('supplier.destroy',$supplier->idprov)}}" method="POST">
                            
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger pt-2">Borrar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop

@section('js')
    <script src="https://kit.fontawesome.com/d2c478c6c0.js" crossorigin="anonymous"></script>
@stop
