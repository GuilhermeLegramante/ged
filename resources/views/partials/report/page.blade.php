@extends('partials.report.master')

@php
    $titleFormattted = ucwords(mb_strtolower($title));
@endphp

@section('titulo', $titleFormattted)

@section('body')
    <body style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;">
        @yield('content')
    </body>
@endsection
