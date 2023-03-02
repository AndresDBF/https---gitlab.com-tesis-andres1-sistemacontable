@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
    <h1>Registro de Clientes</h1>
@stop

@section('content')
    <a href="clientes/create" class="btn btn-primary mb-3">CREAR</a>
    <table id="articulos" class="table table-striped table-bordered shadow-lg mt-4" style="width: 100%">

        <thead class="bd-primary text-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Codigo</th>
                <th scope="col">Descripcion</th>
                <th scope="col">Cantidad</th>
                <th scope="col">Precios</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($articulos as $articulo)
                <tr>
                    <th>{{$articulo->id}}</th>
                    <th>{{$articulo->codigo}}</th>
                    <th>{{$articulo->descripcion}}</th>
                    <th>{{$articulo->cantidad}}</th>
                    <th>{{$articulo->precio}}</th>
                    <td>
                        <form action="{{route('clientes.destroy',$articulo->id)}}" method="POST">
                            <a href="/articulos/{{$articulo->id}}/edit" class="btn btn-info">Editar</a>
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Borrar</button>
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
