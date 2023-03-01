@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>contenido publico</p>
    @role('admin')
    <p>contenido administrativo</p>
    @endrole
    @role('escritor')
    <p>contenido del escritor</p>
    @endrole
@stop