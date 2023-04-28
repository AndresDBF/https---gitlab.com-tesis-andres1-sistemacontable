@extends('layouts.app')

@section('content')
    <div class="w-100 d-flex flex-column flex-md-row justify-content-center pt-2">
        {{-- @for ($i = 0; $i < 3; $i++)
            @include('../components/card-x')
        @endfor --}}
    </div>
    <div class="container my-5">
        <div class="w-100 d-flex flex-column align-items-center justify-content-center mb-3">
            <h2 class="text-uppercase mon-black text-wine text-center mt-5">Coberturas que te ofrecemos</h2>
          </div>
        <div id="cotizacion" class="my-5"></div>
        
    </div>
    <a class="text-decoration-none bg-white rounded-pill text-wine fw-bold p-2 ms-3 shadow" style="position: fixed ;top: 75px ;" href="javascript: history.go(-1)">Volver atrás</a>
@endsection