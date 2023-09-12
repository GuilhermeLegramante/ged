<hr>
<div style="margin-top: -7px;" class="w-110 text">
    <table class="w-100 ff-standard">
        <tbody class="fs-8">
            <tr>
                <td>
                    <span>
                        <strong>{{ config('app.name') }}</strong> v{{ config('messages.version') }}
                    </span>
                    {{ $client->companyName }}
                </td>
                <td class="text-center">
                    <p>{PAGENO} de {nb}</p>
                </td>
            </tr>
        </tbody>
    </table>
</div>
