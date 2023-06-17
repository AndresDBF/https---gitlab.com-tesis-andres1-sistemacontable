@php
use Collective\Html\FormFacade as Form;
@endphp

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Editar Rol</h1>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            {{session('info')}}
        </div>
        
    @endif
    <div class="card">
        <div class="card-body">
            {!! Form::model($role, ['route' => ['roles.update',$role], 'method' => 'put']) !!}
                @include('admin.roles.partials.form')
                {!! Form::submit('Actualizar', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@stop