@extends('adminlte::page')

@section('title', 'Retenciones')

@section('content_header')
    <h1>Pagos Pendientes por Retencion de I.V.A</h1>
@stop

@section('content')
<table id="purchase" class="table table-striped table-bordered shadow-lg mt-4" style="width: 100%">

    <thead class="bd-primary text-dark">
        <tr>
            <th scope="col">Fecha de Factura</th>
            <th scope="col">Nombre del Beneficiario</th>
            <th scope="col">Identificación</th>
            <th scope="col">Numero de factura </th>
            <th scope="col">Monto Total de la Factura</th>
            <th scope="col">Acción</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            @foreach ($registerOrderPay as $index => $pay)
                <tr>
                    <th>{{ $pay->fec_emi }}</th>
                    <th>{{ $supplier[$index]->nombre }}</th>
                    <th>{{ $supplier[$index]->tipid}}-{{ $supplier[$index]->identificacion }}-{{$supplier[$index]->tiprif}}</th>
                    <th>{{ $pay->numfact}}</th>
                    @if ($pay->moneda != 'BS')
                        <th>{{ $pay->montototalmoneda}}</th>
                    @else
                        <th>{{ $pay->montototallocal}}</th>
                    @endif 
                    <td>       
                        <a href="#" class="btn btn-info mb-2" onclick="confirmCrear('{{route('createretention',['idorpa' => $pay->idorpa , 'idprov' => $pay->idprov])}}')"><i class="fas fa-check"></i></a>
                    </td>
                </tr>
            @endforeach
        </tr>
    </tbody>
</table>
@stop

@section('js')
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