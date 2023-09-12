<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        .h-30 {
            height: 40px
        }

        .w-40 {
            width: 40%
        }

        .w-100 {
            width: 100%
        }

        .ff-standard {
            font-family: Arial, Helvetica, sans-serif
        }

        .fs-8 {
            font-size: 8pt
        }

        .border-top {
            border-top: 1px solid gray;
        }
        .text {
            letter-spacing: 0.1rem;
        }
    </style>
</head>

<body class="h-30">
    <br>
    <div class="w-110 text">
        <table class="w-100 ff-standard">
            <tbody class="fs-8">
                <tr>
                    <td class="border-top">
                        <span>
                            <strong>{{ config('app.name') }}</strong> v{{ config('messages.version') }}
                        </span>
                        {{ $client->companyName }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
