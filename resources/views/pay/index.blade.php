@extends('adminlte::page')

@section('title', 'Registrar Pago')

@section('content_header')
    <h1>Ordenes de Pago Pendientes</h1>
@stop

@section('content')
    @if(session('mensaje'))
    <div class="alert alert-success" role="alert">
        {{ session('mensaje') }}
    </div>
    @endif
    <table id="purchase" class="table table-striped table-bordered shadow-lg mt-4" style="width: 100%">
        <thead class="bd-primary text-dark">
            <tr>
                <th scope="col">Numero de Relacion de Egreso</th>
                <th scope="col">Nombre del Beneficiario</th>
                <th scope="col">Moneda</th>
                <th scope="col">Tipo de Pago</th>
                <th scope="col">Monto de Orden de Pago</th>
                @can('createpay')
                    <th scope="col">Acción</th>
                @endcan
               
            </tr>
        </thead>
        <tbody>
            @foreach ($registerPay as $index => $pay)
                <tr>
                    <th>{{ $pay->num_egre }}</th>
                    <th>{{ $pay->nombre }}</th>
                    <th>{{ $pay->moneda }}</th>
                    @switch($pay->tippago)
                        @case('EFE')
                            <th>EFECTIVO</th>
                            @break
                        @case('TRA')
                            <th>TRANSFERENCIA BANCARIA</th>
                            @break
                        @case('PMO')
                            <th>PAGO MOVIL</th>
                            @break
                        @case('TDE')
                            <th>TARJETA DE DEBITO</th>
                            @break
                        @case('TCR')
                            <th>TARJETA DE CREDITO</th>
                            @break
                    @endswitch
                    @if ($pay->moneda != 'BS')
                        <th>{{ $detPayOrder[$index]->montototalmoneda}}</th>
                    @else
                        <th>{{ $detPayOrder[$index]->montototallocal}}</th>
                        
                    @endif
                    @can('createpay')
                        <td>
                            
                            <a href="#" class="btn btn-success mb-2" onclick="confirmCrear('{{route('createpay',['idprov' => $pay->idprov , 'idorpa' => $pay->idorpa])}}')"><i class="fas fa-check"></i></a>
                            <a href="#" class="btn btn-danger mb-2" onclick="ConfirmElimi('{{route('deletepay',['idorpa' => $pay->idorpa])}}')"> <i class="fas fa-trash-alt"></i></a>
                        </td>
                    @endcan
                    
                </tr>
            @endforeach
        </tbody>
    </table>

@stop

@section('css')

<style>
    /* Estilos adicionales para el botón */
    .btn-info {
        color: #fff;
        background-color: #17a2b8;
        border-color: #17a2b8;
    }
</style>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmCrear(url) {
            Swal.fire({
                title: 'Confirmación',
                text: '¿Crear El Registro de Pago?',
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
    <script>
        function ConfirmElimi(url) {
            Swal.fire({
                title: 'Confirmación',
                text: '¿Desea Eliminar la Orden de Pago?',
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