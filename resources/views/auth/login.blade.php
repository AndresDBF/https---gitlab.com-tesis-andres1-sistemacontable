@extends('layouts.app')

@section('content')
<div class="w-100 h-100" style="background-image: url('http://localhost:8000/storage/fondo-de-login.png') ;background-size: cover;background-position: center;">
    <div class="container py-5 w-100">
        <div class="row my-5">
            <div class="col-md-4 my-5">
                <div class="card border-10">
                    <!--<div class="card-header">{{ __('Login') }}</div>-->
                    <div class="w-100 d-flex justify-content-center px-5 py-3">
                        <img class="w-100" src="https://cotiseguros.com.ve/storage/LOGO%20RGB_Color.png" alt="">
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
    
                            <div class="row mb-3">
                                <!--<label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>-->
    
                                <div class="col-md-12">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
    
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="row mb-3">
                                <!--<label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>-->
    
                                <div class="col-md-12">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
    
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="row">
                                <div class="col-12 d-flex justify-content-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
    
                                        <label class="form-check-label mon-light" for="remember">
                                            Mantener sesion iniciada
                                        </label>
                                    </div>
                                </div>
                            </div>
    
                            <div class="row mb-0">
                                <div class="col-12 d-flex align-items-center flex-column">
                                    @if (Route::has('password.request'))
                                        <a class="text-pink my-2 mon-light text-decoration-none" href="{{ route('password.request') }}">
                                            Olvide mi contrasena
                                        </a>
                                    @endif
                                    <button type="submit" class="btn bg-pink text-white rounded-pill w-25 my-2">
                                        Enviar
                                    </button>
    
                                    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
