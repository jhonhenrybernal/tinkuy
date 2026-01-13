@extends('themes.xylo.layouts.auth')

@section('content')
<div class="login-page min-vh-100 d-flex align-items-center justify-content-center mt-4">
    <div class="row w-100 g-0">

        {{-- Left Section --}}
        <div class="col-lg-6 d-flex flex-column justify-content-center text-white px-5 py-5"
             style="background-color: #0e0e0e;">
            
            <div class="mb-5 fs-1 fw-bold text-warning">*</div>

            <div class="fw-bold display-4 mb-3 lh-sm">
                Restablecer <br> contraseña
            </div>

            <div class="fs-2 fw-semibold mb-4 text-light">
                Te enviaremos un enlace
            </div>

            <p class="text-light mb-5 opacity-75 fs-6">
                Ingresa tu correo y recibirás un link para crear una nueva contraseña.
            </p>

            <div class="mt-auto text-center w-100 text-secondary small opacity-75 pt-4 border-top border-secondary">
                {{ __('store.register.copyright') }}
            </div>
        </div>

        {{-- Right Section --}}
        <div class="col-lg-6 d-flex flex-column justify-content-center align-items-center bg-white p-5">
            
            <div class="text-center mb-4">
                <img src="{{ asset('storage/brands/logo-ready.png') }}" width="160" alt="Main Logo">
            </div>

            <h2 class="fw-semibold mb-2 text-dark">
                ¿Olvidaste tu contraseña?
            </h2>

            <p class="text-muted mb-4 text-center px-3">
                Escribe tu correo y te enviaremos el enlace de restablecimiento.
            </p>

            {{-- Mensaje de éxito --}}
            @if (session('status'))
                <div class="alert alert-success w-100">
                    {{ session('status') }}
                </div>
            @endif

            <form class="w-100" method="POST" action="{{ route('customer.password.email') }}">
                @csrf

                <div class="mb-3">
                    <input type="email" name="email" value="{{ old('email') }}"
                           placeholder="Correo electrónico"
                           class="form-control rounded-3 p-2">
                    @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <button type="submit"
                        class="btn w-100 py-2 rounded-3 fw-semibold text-white border-0"
                        style="background-color: #0e0e0e; transition: all 0.3s ease;">
                    Enviar enlace
                </button>
            </form>

            <p class="mt-4 mb-0 text-muted">
                ¿Ya la recordaste?
                <a href="{{ route('customer.login') }}" class="text-decoration-none fw-semibold">
                    Inicia sesión
                </a>
            </p>
        </div>
    </div>
</div>
@endsection
