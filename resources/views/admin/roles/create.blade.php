@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Crear Rol</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Ingrese el nombre del rol">
                    @error('name')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>

                <h2 class="h3">Lista de Permisos</h2>

                @foreach ($permissions as $permission)
                    <div>
                        <label>
                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="mr-1">
                            {{ $permission->description }}
                        </label>
                    </div>
                @endforeach 

              {{--   @for ($i = 1; $i < count($permissions); $i++)
                    <div>
                        <label>
                            <input type="checkbox" name="permission_{{ $i }}" value="{{ $permissions[$i]->id }}" class="mr-1">
                            {{ $permissions[$i]->description }}
                        </label>
                    </div>
                @endfor --}}


                <button type="submit" class="btn btn-primary">Crear Rol</button>
            </form>
        </div>
    </div>
@stop
