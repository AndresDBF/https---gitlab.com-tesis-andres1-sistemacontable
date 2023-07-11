@extends('adminlte::page')

@section('title', 'Retenciones I.V.A')

@section('content_header')
    <h1>Pagos Pendientes por Retencion de I.V.A</h1>
@stop

@section('content')
<button type="button" class="btn btn-primary mb-3"  data-bs-toggle="modal"  data-bs-target="#retening"> Retenciones por Ingresos</button>
<table id="purchase" class="table table-striped table-bordered shadow-lg mt-4" style="width: 100%">
    <thead class="bd-primary text-dark">
        <tr>
            <th scope="col">Relación de Egreso</th>
            <th scope="col">Nombre del Beneficiario</th>
            <th scope="col">Identificación</th>
            <th scope="col">Numero de factura </th>
            <th scope="col">Fecha de Control</th>
            <th scope="col">Monto Total de la Factura</th>
            @can('createretention')
                <th scope="col">Acción</th>
            @endcan
           
        </tr>
    </thead>
    <tbody>
        <tr>
            @foreach ($registerOrderPay as $index => $pay) 
                <tr>
                    <th>{{ $pay->num_egre }}</th>
                    <th>{{ $supplier[$index]->nombre }}</th>
                    <th>{{ $supplier[$index]->tipid}}-{{ $supplier[$index]->identificacion }}-{{$supplier[$index]->tiprif}}</th>
                    <th>{{ $pay->numfact}}</th>
                    <th>{{ $pay->numctrl }}</th>
                    <th>{{ $pay->baseimponiblelocal}}</th>
                    @can('createretention')
                        <td>       
                            <a href="#" class="btn btn-info mb-2" onclick="confirmCrear('{{route('createretention',['idorpa' => $pay->idorpa , 'idprov' => $pay->idprov])}}')"><i class="fas fa-check"></i></a>
                        </td>
                    @endcan
                   
                </tr>
            @endforeach
        </tr>
    </tbody>
</table>


<div class="modal fade" id="retening" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="reteningLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Lista de Retenciones Pendientes por Ingresos</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <table id="nomina" class="table table-striped table-bordered shadow-lg mt-4" style="width: 100%">
                <thead class="bd-primary text-dark">
                    <tr>
                        <th scope="col">Fecha de Factura</th>
                        <th scope="col">Numero de factura </th>
                        <th scope="col">Numero de Control </th>
                        <th scope="col">Base Imponible de la Factura</th>
                        @can('createretening')
                            <th scope="col">Acción</th>
                        @endcan
                       
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @foreach ($registerIncome as $income)
                            <tr>
                                <th>{{$income->fec_emi}}</th>
                                <th>{{$income->numfact}}</th>
                                <th>{{$income->numctrl}}</th>
                                <th>{{$income->mtoimponiblelocal}}</th>
                                @can('createretening')
                                    <th>
                                        <a href="{{route('createretening',['idfact' => $income->idfact,'idcli' => $income->idcli])}}" class="btn btn-info"><i class="fas fa-check"></i></a>
                                    </th> 
                                @endcan
                               
                            </tr>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
          {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <a href="{{route('createvalue')}}">
            <button type="button" class="btn btn-primary">Crear</button>
          </a> --}}
        </div>
      </div>
    </div>
</div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>   
<script src="https://kit.fontawesome.com/d2c478c6c0.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmCrear(url) {
            Swal.fire({
                title: 'Confirmación',
                text: '¿Realiza la Retención de I.V.A?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }
    </script>
@endsection