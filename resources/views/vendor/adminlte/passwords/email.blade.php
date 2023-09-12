@extends('adminlte::master')

@section('adminlte_css_pre')
<link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@stop

@section('adminlte_css')
@stack('css')
@yield('css')
@stop

@section('classes_body', 'login-page')

@php( $password_email_url = View::getSection('password_email_url') ?? config('adminlte.password_email_url',
'password/email') )
@php( $dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home') )

@if (config('adminlte.use_route_url', false))
@php( $password_email_url = $password_email_url ? route($password_email_url) : '' )
@php( $dashboard_url = $dashboard_url ? route($dashboard_url) : '' )
@else
@php( $password_email_url = $password_email_url ? url($password_email_url) : '' )
@php( $dashboard_url = $dashboard_url ? url($dashboard_url) : '' )
@endif

@section('body')
<div class="login-page" style="background-image: url('../vendor/adminlte/dist/img/fundo.jpg');
    background-size: cover; width:100%;">
    <div class="login-box" style="border-radius: 12px; background: #ffffff; opacity: 100%; position: absolute; z-index: 99;">
        <div class="login-logo">
            <img style="width:150px;" src="../vendor/adminlte/dist/img/logo.jpg" alt=""><br>
            <a style="font-weight: 350;" href="{{ $dashboard_url }}">hs<strong>Cidadao</strong></a>
        </div>

        <div class="card">
            <div class="card-body login-card-body" style="opacity: 200%;">
                <p class="login-box-msg">{{ __('adminlte::adminlte.password_reset_message') }}</p>
                @if (session('status'))
                <div class="alert alert-success">
                    E-mail enviado com sucesso!
                </div>
                @endif
                <form action="{{ $password_email_url }}" method="post">
                    {{ csrf_field() }}
                    <div class="input-group mb-3">
                        <input type="email" name="email"
                            class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                            value="{{ old('email') }}" placeholder="{{ __('adminlte::adminlte.email') }}" autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @if ($errors->has('email'))
                        <div class="invalid-feedback">
                            <strong>{{$errors->first('email')}}</strong>
                        </div>
                        @endif
                    </div>
                    <button type="submit" style="border-radius: 4px;" class="btn btn-primary btn-block btn-flat">
                        {{ __('adminlte::adminlte.send_password_reset_link') }}
                    </button>
                </form>
                
                @include('includes.copyright')
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
<link rel="icon" href="{{ URL::asset('img/logo.jpg') }}" type="image/x-icon" />
@endsection

@section('js')
<script src="{{asset('js/custom.js')}}"></script>
@endsection

@section('adminlte_js')
<script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
@stack('js')
@yield('js')
@stop