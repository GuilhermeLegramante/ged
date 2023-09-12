<div class="h-110 mt-20 b-ab">
    <table style="padding-top: 25px; padding-left: 10px; padding-right: 10px;" class="w-100">
        <tbody>
            <tr>
                <td class="va-middle w-10">
                    <img src="{{ public_path('img/brasao.png') }}" style="width: 8%;">
                </td>
                <td class="h-64 w-55">
                    <table>
                        <tbody>
                            <tr>
                                <td class="fs-16"><strong>
                                        <p>{{ $title }}</p>
                                    </strong></td>
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
                                    <span><strong>Emissor:</strong></span> {{ session()->get('username') }}
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
