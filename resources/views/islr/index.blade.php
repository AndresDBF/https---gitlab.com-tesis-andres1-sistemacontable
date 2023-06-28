@extends('adminlte::page')

@section('title', 'Retenciones Impuesto sobre la Renta')

@section('content_header')
    <h1>Retenciones I.S.L.R</h1>
@stop

@section('content')
    <div class="container">
        @if(Session::has('error'))
        <div class="alert alert-danger">{{Session::get('error')}}</div>
        @endif
        @if(session('message'))
        <div class="alert alert-success" role="alert">
            {{ session('message') }}
        </div>
        @endif
        <div class="card">
            <div class="card-header">
                <h3 class="text-center fw-bolder">Lista de Contribuyentes Especiales</h3>
            </div>
            <div class="card-body pl-6">
                <form action="{{route('listreten')}}" method="POST">
                    @csrf
                    <div class="well">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-label">
                                    <label for="dni">Tipo de contribuyente de Agente Especial</label>
                                    <select name = 'tipcontribuyente' id ="tipcontribuyente" class="custom-select">
                                        <option selected="">Seleccionar Agente</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-label">
                                    <label for="dni">Tipo de contribuyente de Agente Especial</label>
                                    <select name = 'tipagente' id ="tipagente" class="custom-select">
                                        <option selected="">Seleccionar concepto de Agente</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                                <a href="/home" class="btn btn-secondary" tabindex="5"><i class="fas fa-home"></i></a>
                                <button type="submit" class="btn btn-primary" tabindex="6"><i class="fas fa-check"></i></button>
                            </div> 
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script 
        src="http://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        var myModal = document.getElementById('myModal')
        var myInput = document.getElementById('myInput')

        myModal.addEventListener('shown.bs.modal', function () {
        myInput.focus()
        })
    </script>
    <script src="{{asset('js/process/agentereten.js')}}"></script>
@endsection