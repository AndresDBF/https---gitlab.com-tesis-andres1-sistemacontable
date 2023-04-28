@extends('layouts.app')

@section('content')
    {{-- @include('../components/banner-index') --}}
    <div class="w-100 d-flex flex-column flex-md-row justify-content-center align-items-center">
        {{-- @for ($i = 0; $i < 3; $i++)
            @include('../components/card-x')
        @endfor --}}
    </div>
    <form id="form-cot" class="container px-4 my-5" action="/cotizador/salud/cotizacion" method="post">
        
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <h3 class="mon-black display-4 text-uppercase text-center my-5 text-wine">Cotiza tu poliza <br/> Ingresa tus datos</h3>
        <div class="row br-5 shadow-lg px-4 py-4">
            <div class="col-12">
                <h3 class="mon-black display-6 text-uppercase text-wine mb-4">información personal</h3>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-floating mb-3">
                    <input value="{{ Auth::check() ? Auth::user()->name : '' }}" name="name" type="text" class="form-control shadow-none border-0 bg-grey" id="floatingInput" placeholder="" required>
                    <label class="mon-regular" for="floatingInput">Nombre</label>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-floating mb-3">
                    <input value="{{ Auth::check() ? Auth::user()->lastname : '' }}" name="last_name" type="text" class="form-control shadow-none border-0 bg-grey" id="floatingInput" required>
                    <label class="mon-regular" for="floatingInput">Apellido</label>
                </div>
            </div>
            <div class="col-12 col-md-6 d-flex">
                <select id="input-code" name="code" class="form-select shadow-none border-0 bg-grey w-25 align-self-start" style="height: 58px ;" aria-label="Default select example" required>
                   
                    @foreach ($codes as $cp)
                        <option @if( $cp["callingCodes"][0] == 58 ) selected @endif value="+{{$cp["callingCodes"][0]}}">(+{{ $cp["callingCodes"][0] }}) {{ $cp["name"] }}</option>
                    @endforeach 
                </select>
                <div class="form-floating mb-3 w-75 ms-3">
                    <input id="input-phone" name="phone" type="number" class="form-control shadow-none border-0 bg-grey" id="floatingInput" required>
                    <label class="mon-regular" for="floatingInput">Nro de telefono</label>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-floating mb-3">
                    <input value="{{ Auth::check() ? Auth::user()->email : '' }}" name="email" type="email" class="form-control shadow-none border-0 bg-grey" id="floatingInput" required>
                    <label class="mon-regular" for="floatingInput">Correo electrónico</label>
                </div>
            </div>
            <div class="col-12 col-md-6 d-flex">
                <select name="province" class="form-select w-100 shadow-none border-0 bg-grey w-25 align-self-start" style="height: 58px ;" aria-label="Default select example" required>
                    @foreach ($provinces as $p)
                        <option value="{{ $p["estado"] }}">{{ $p["estado"] }}</option>
                    @endforeach 
                </select>
            </div>
            <div class="col-12">
                <hr class="mt-3" />
            </div>
            <div class="col-12 my-3">
                <h3 class="mon-bold h3 text-uppercase mb-4 text-wine">Suma asegurada</h3>
                <select name="coverage" class="w-auto form-select shadow-none border-0 bg-grey align-self-start" style="height: 58px ;" aria-label="Default select example">
                    <option value="">Elije tu cobertura</option>
                    @foreach ($coverages as $c)
                        <option value="{{ $c->coverage }}">{{ number_format( $c->coverage ) }} USD</option> 
                    @endforeach
                </select>
            </div>
            <h3 class="mon-black display-6 text-uppercase mt-3 text-wine">personas a asegurar</h3>
            <div id="cotizador"></div>
            <div class="col-12">
                <hr class="mt-3" />
            </div>
            <!--<div class="col-12 col-md-6 my-2">
                <h3 class="mon-black display-6 text-uppercase mb-4 text-wine">Suma asegurada</h3>
                <select name="coverage" class="w-auto form-select shadow-none border-0 bg-grey align-self-start" style="height: 58px ;" aria-label="Default select example">
                    <option value="">Elije tu cobertura</option>
                    @foreach ($coverages as $c)
                        <option value="{{ $c->coverage }}">{{ number_format( $c->coverage ) }} USD</option> 
                    @endforeach
                </select>
            </div>-->
        </div>
        <!--<div class="w-100 d-flex justify-content-center">
            <button class="btn bg-pink text-white rounded-pill py-3 px-5 my-5" type="submit">Encuentra tu poliza ideal</button>
        </div>-->
    </form>
    <script>
        
    </script>
@endsection