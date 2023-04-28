@extends('voyager::master')

@section('content')
<style>
    .bg-white {
        background-color: white;
    }
</style>
<div class="table-responsive">
    @foreach ($insurers as $insurer)
    <form action="/admin/excel" method="POST" enctype="multipart/form-data">
        @csrf
        <table class="table table-bordered bg-white">
            <tr>
                <td>{{ $insurer->name }}</td>
                <td>
                    <input type="file" name="excel" required>
                </td>
                <td>
                  <button class="btn btn-primary btn-lg" type="submit" value="Submit">Actualizar coberturas</button>
                </td>
            </tr>
          </table>
    </form>
    @endforeach
    
    @if ( isset( $message ) )
        @if( $message["status"] )
            <div aria-hidden="true" data-dismiss="alert" aria-label="Close" class="alert alert-success alert-dismissible" role="alert" style="position: fixed;bottom: 0px ; right: 10px ;">
                <strong>{{ $message["message"] }}</strong>
            </div>
        @else
            <div aria-hidden="true" data-dismiss="alert" aria-label="Close" class="alert alert-danger alert-dismissible" role="alert" style="position: fixed;bottom: 0px ; right: 10px ;">
                <strong>{{ $message["message"] }}</strong>
            </div>
        @endif
    @endif

    
    
  </div>
@endsection