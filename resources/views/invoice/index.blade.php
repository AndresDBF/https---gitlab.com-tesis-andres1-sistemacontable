@extends('adminlte::page')

@section('title', 'Facturación')

@section('content_header')
    <h1>Lista de Clientes</h1>
@stop

@section('content')
    <table id="invoice" class="table table-striped table-bordered shadow-lg mt-4" style="width: 100%">

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
            @foreach ($customer as $cli)
                <tr>
                    <th>{{$cli->idcli}}</th>
                    <th>{{$cli->nombre}}</th>
                    <th>{{$cli->identificacion}}</th>
                    <th>{{$cli->stscontr}}</th>
                    @if ($cli->tip_pag == 'ANU')
                        <th>ANUAL</th>
                    @elseif($cli->tip_pag =='MEN')
                        <th>MENSUAL</th>
                    @elseif ($cli->tip_pag == 'SEM')
                        <th>SEMESTRAL</th>
                    @else 
                        <th>TRIMESTRAL</th>
                    @endif
                    <td>
                        <a href="{{ route('createinvoiceing', ['idcli' => $cli->idcli]) }}" class="btn btn-info mb-2" onclick="confirmCreate(event, '{{ route('createinvoiceing', ['idcli' => $cli->idcli]) }}')"><i class="fas fa-check"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" class="text-center">
                    {{ $customer->links() }}
                </td>
            </tr>
        </tfoot>
    </table>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmCreate(event, editUrl) {
            event.preventDefault();

            Swal.fire({
                title: '¿Confirmación?',
                text: 'Crear la factura de ingreso?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, editar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = editUrl;
                }
            });
        }
    </script>
@endsection