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
                <th scope="col">Status de Contrato</th>
                <th scope="col">Tipo de Contrato</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
           
        </tbody>
    </table>
@stop

@section('js')
    <script src="https://kit.fontawesome.com/d2c478c6c0.js" crossorigin="anonymous"></script>
@stop
