@extends('adminlte::page')

@section('title', 'Crear Proyeccion de Gastos')

@section('content_header')
    <h1 class="text-secondary fs-5 shadow-lg p-2 mb-5 bg-body rounded text-center">Nueva Proyeccion de Gastos</h1>
@stop

@section('content')
    <div class="container">
        <form action="{{route('storeproyectgast')}}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Registrar Proyección de Gastos del {{$fecstsini}} al {{$fecstsfin}}</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="" class="form-label">Monto del Presupuesto (BS) </label>
                                <input type="numeric" name="amount" id="amount" class="form-control" tabindex="1" step="0.01" pattern="^\d+(\.\d{1,2})?$">
                            </div>
                        </div>
                    </div>
                    <div class="well pb-3 mt-3">
                        <a href="{{route('proyectgast')}}" class="btn btn-secondary" tabindex="2">Atras</a>
                        <button type="submit" class="btn btn-primary" tabindex="3">Siguiente</button>
                    </div>
                </div>
            </div>
            <input type="hidden" name="amountseat" value="{{$seats}}">
            <input type="hidden" name="fecstsini" value="{{$fecstsini}}">
            <input type="hidden" name="fecstsfin" value="{{$fecstsfin}}">
        </form>

        <div class="alert alert-dark text-center" role="alert">
            Ingresos Totales disponibles para la quincena : {{$seats}} BS
            
        </div>
    </div>
@stop

@section('js')
<script>
var toastElList = [].slice.call(document.querySelectorAll('.toast'))
var toastList = toastElList.map(function (toastEl) {
  return new bootstrap.Toast(toastEl, option)
})
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.min.js"></script>


@endsection

