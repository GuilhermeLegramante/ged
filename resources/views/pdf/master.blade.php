<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/pdf.css') }}">
    <link rel="icon" href="{{ asset('img/logo-nova.png') }}" type="image/x-icon" />
    <title>@yield('titulo')</title>
</head>

@yield('body')
    <style>
        @page {
            margin: 8mm 8mm 8mm 8mm;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            font-size: 10%;
        }

        .background-image {
            background: url("{{ asset('img/brasao-faded.jpg') }}");
            background-size: 90%;
            background-repeat: no-repeat;
            background-position: center;
            height: 100%;
        }
    </style>
</html>
