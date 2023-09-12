<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        .w-10 {
            width: 10%
        }

        .w-50 {
            width: 50%
        }

        .w-100 {
            width: 100%
        }

        .h-10 {
            height: 10px;
        }

        .h-50 {
            height: 50px
        }

        .h-64 {
            height: 64px
        }

        .h-100 {
            height: 100px
        }

        .h-110 {
            height: 110px
        }

        .max-w100 {
            max-width: 100%
        }

        .text-right {
            text-align: right
        }

        .ff-standard {
            font-family: Arial, Helvetica, sans-serif
        }

        .fs-12 {
            font-size: 12px
        }

        .fs-14 {
            font-size: 14px
        }

        .fs-18 {
            font-size: 18px
        }

        .pt-10 {
            padding-top: 10px;
        }

        .va-bottom {
            vertical-align: bottom
        }

        .va-middle {
            vertical-align: middle
        }

        .b-ab {
            border-bottom: 1px solid #000000;
        }
    </style>
</head>

<body>
    <div class="h-110 b-ab">
        <table class="w-100 ff-standard">
            <tbody>
                <tr>
                    <td class="va-middle w-10">
                        <img src="{{ public_path('img/brasao.png') }}" class="max-w100 h-100">
                    </td>
                    <td class="h-64 w-55">
                        <table>
                            <tbody>
                                <tr>
                                    <td class="fs-18"><strong>{{ $title }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="fs-14"><strong>{{ env('BRANDS_DEPARTAMENT') }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="fs-12 pt-10">
                                        <span><strong>CNPJ:</strong></span> {{ $client->document }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fs-12">
                                        <span><strong>Emissor:</strong></span> {{ $username }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td class="h-64">
                        <table class="w-100">
                            <tbody>
                                <tr class="h-40">
                                    <td class="fs-18"></td>
                                </tr>
                                <tr>
                                    <td class="fs-14 text-right">
                                        <strong>&nbsp;</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    {{-- <td class="fs-12 text-right">
                                        <strong>Período:</strong> 01/01/2021 a 31/12/2022
                                    </td> --}}
                                </tr>
                                <tr>
                                    <td class="fs-12 text-right va-bottom">
                                        <strong>Emissão:</strong> {{ date('d/m/Y \à\s H:i:s') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
