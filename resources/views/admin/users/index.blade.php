@extends('adminlte::page')

@section('title', 'Lista de Usuarios')

@section('content_header')
    <h1>Lista de Usuario</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <table id="purchase" class="table table-striped table-bordered shadow-lg mt-4" style="width: 100%">

                <thead class="bd-primary text-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre de Usuario</th>
                        <th scope="col">Email</th>
                        <th scope="col">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $u)
                    <tr>
                        <th>{{ $u->id}}</th>
                        <th>{{ $u->name }}</th>
                        <th>{{ $u->email }}</th>
                        <td width = "10px">
                            <a href="{{ route('users.edit', $u->id) }}" class="btn btn-info mb-2">Editar</a>
                            <br>
                        
                            
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="card-footer">
        @if ($users->hasPages())
            <tr>
                <td colspan="6" class="text-center">
                
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            
                            @if ($users->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $users->previousPageUrl() }}" rel="prev">&laquo;</a></li>
                            @endif

                        
                            @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                                @if ($page == $users->currentPage())
                                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach

                        
                            @if ($users->hasMorePages())
                                <li class="page-item"><a class="page-link" href="{{ $users->nextPageUrl() }}" rel="next">&raquo;</a></li>
                            @else
                                <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                            @endif
                        </ul>
                    </nav>
                </td>
            </tr>
        @endif
    </div>
@stop

@section('css')
    
@endsection