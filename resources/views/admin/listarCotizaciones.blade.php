@extends('voyager::master')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/howler/2.2.1/howler.min.js"></script>
<script src="{{ asset('js/App.js') }}" defer></script>
<div class="container">
    <div class="row">
        <div class="col-12" id="listarCotizaciones"></div>
    </div>
</div>
@endsection