@php
    use Collective\Html\FormFacade as Form;
@endphp

@extends('adminlte::page')

@section('title', 'Lista de Usuario')

@section('content_header')
    <h1>Editar Usuario</h1>
@stop

@section('content')
    @if (session('info'))
    <div class="alert alert-success">
        <strong>{{session('info')}}</strong>
    </div>
    @endif
    <div class="card">
        <div class="card-body">
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}" required>
                </div>

                <div class="form-group">
                    <label for="name">email</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ $user->email }}" required>
                </div>
                
                @foreach ($roles as $role)
                    <div class="form-check">
                        {{ Form::checkbox('roles[]', $role->id, false, ['class' => 'form-check-input','id' => 'role-'.$role->id]) }}
                        {{ Form::label('role-'.$role->id, $role->name, ['class' => 'form-check-label']) }}
                    </div>
                @endforeach
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </form>
        </div>
    </div>
@stop