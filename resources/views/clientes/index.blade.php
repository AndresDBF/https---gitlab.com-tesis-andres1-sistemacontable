@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
    <h1>Registro de Clientes</h1>
@stop

@section('content')
    @if(session('mensaje'))
    <div class="alert alert-success" role="alert">
        {{ session('mensaje') }}
    </div>
    @endif
    <a href="clientes/create" class="btn btn-primary mb-3">CREAR</a>
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
            @foreach ($customer as $cli)
                <tr>
                    <th>{{$cli->idcli}}</th>
                    <th>{{$cli->nombre}}</th>
                    @if ($cli->tiprif != null)
                        <th>{{$cli->tipid}}-{{ $cli->identificacion}}-{{$cli->tiprif}}</th>
                    @else
                        <th>{{$cli->tipid}}-{{ $cli->identificacion}}</th>
                    @endif
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
                        <a href="{{ route('clientes.edit', ['cliente' => $cli->idcli]) }}" class="btn btn-info mb-2" onclick="confirmEdit(event, '{{ route('clientes.edit', ['cliente' => $cli->idcli]) }}')">Editar</a>

                        <form action="{{route('clientes.destroy',$cli->idcli)}}" method="POST" id="deleteForm{{$cli->idcli}}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger pt-2" onclick="confirmDelete(event, 'deleteForm{{$cli->idcli}}')">Borrar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
     <!-- Mostrar enlaces de paginación -->
     @if ($customer->hasPages())
     <tr>
         <td colspan="6" class="text-center">
            
             <nav aria-label="Page navigation example">
                 <ul class="pagination">
                     
                     @if ($customer->onFirstPage())
                         <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                     @else
                         <li class="page-item"><a class="page-link" href="{{ $customer->previousPageUrl() }}" rel="prev">&laquo;</a></li>
                     @endif
 
                    
                     @foreach ($customer->getUrlRange(1, $customer->lastPage()) as $page => $url)
                         @if ($page == $customer->currentPage())
                             <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                         @else
                             <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                         @endif
                     @endforeach
 
                    
                     @if ($customer->hasMorePages())
                         <li class="page-item"><a class="page-link" href="{{ $customer->nextPageUrl() }}" rel="next">&raquo;</a></li>
                     @else
                         <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                     @endif
                 </ul>
             </nav>
         </td>
     </tr>
     @endif
@stop

@section('js')
    <script src="https://kit.fontawesome.com/d2c478c6c0.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmEdit(event, editUrl) {
            event.preventDefault();
    
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Seguro que desea editar este cliente?',
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
    
        function confirmDelete(event, formId) {
            event.preventDefault();
    
            Swal.fire({
                title: '¿Estás seguro?',
                text: '¿Seguro que desea eliminar este cliente?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }
    </script>
    
    
    
@stop
