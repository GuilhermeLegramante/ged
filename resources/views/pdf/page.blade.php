@extends('pdf.master')

@section('titulo', $title)

@section('body')
    <body>
        <htmlpageheader name="page-header">
            @include($header)
        </htmlpageheader>

        <htmlpagefooter name="page-footer">
            @include($footer)
        </htmlpagefooter>
        @yield('content')
    </body>
@endsection
