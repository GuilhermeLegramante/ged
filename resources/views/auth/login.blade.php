@extends('adminlte::master')

@section('title', 'hsGED - Login')

@section('adminlte_css_pre')
<link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
<link rel="icon" href="{{ URL::asset('img/logo-nova.png') }}" type="image/x-icon" />
@stop


@section('adminlte_css')
@stack('css')
@yield('css')
@stop

@section('classes_body', 'login-page')

@php($dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home'))

@if (config('adminlte.use_route_url', false))
@php($dashboard_url = $dashboard_url ? route($dashboard_url) : '')
@else
@php($dashboard_url = $dashboard_url ? url($dashboard_url) : '')
@endif

@section('body')
<div class="login-page" style="background-image: url('vendor/adminlte/dist/img/fundo.jpg');
    background-size: cover; width:100%;">
    <div class="login-box" style="border-radius: 12px; background: #ffffff; opacity: 100%; position: absolute; z-index: 99;">
        @include('partials.login-logo-and-text')

        <div class="card">
            <div class="card-body login-card-body" style="opacity: 200%;">
                <p class="login-box-msg">{{ __('adminlte::adminlte.login_message') }}</p>
                @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                <form action="{{ route('login') }}" method="post">
                    {{ csrf_field() }}
                    <div class="input-group mb-3">
                        <input type="text" name="login" class="form-control {{ $errors->has('login') ? 'is-invalid' : '' }}" value="{{ old('login') }}" placeholder="Seu nome de usuário" autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        @if ($errors->has('login'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('login') }}</strong>
                        </div>
                        @endif
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" placeholder="Sua senha">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @if ($errors->has('password'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('password') }}</strong>
                        </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button style="border-radius: 4px;" type="submit" class="btn btn-primary btn-block btn-flat">
                                {{ __('adminlte::adminlte.sign_in') }}
                            </button>
                        </div>
                    </div>
                </form>
                <hr>
                <hr>
                <p style="font-size: 13px; text-align:center;">Desenvolvido por HardSoft Informática &copy;</p>
                <p style="font-size: 13px; text-align:center; margin-bottom:-2px;">Todos os direitos reservados </p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<link rel="icon" href="{{ URL::asset('img/logo-nova.png') }}" type="image/x-icon" />
@endsection

@section('js')
<script src="{{ asset('js/scripts.js') }}"></script>
<script>
    $(document).ready(function() {
        $("input[type=text]").keyup(function() {
            $(this).val($(this).val().toUpperCase());
        });

    });

</script>
@endsection

@section('adminlte_js')
<script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
@stack('js')
@yield('js')
@stop
