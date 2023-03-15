@extends('adminlte::page')

@section('title', 'Excel')

@section('content_header')
    <h1>importar tu excel </h1>
@stop

@section('content')
<div class="container">
    <h3 class="mb-5">carga para importar datos</h3>    
    
    <form action="{{url('excel/importarexcel')}}" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="row">
            <div class="col">
                <input type="file" name="excel" id="" class="form-group" accept=".xlsx, .xls">

            </div>
            <div class="col">
                <input type="submit" value="importar" class="btn btn-outline-info">
            </div>
        </div>
    </form>
</div>
@stop

@section('js')
    <script src="https://kit.fontawesome.com/d2c478c6c0.js" crossorigin="anonymous"></script>
@stop
