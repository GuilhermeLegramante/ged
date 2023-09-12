@if ($item['meanValue'] >= 23)
    <small class="badge badge-secondary"> {{ $item['meanValue'] }} - Moderada Pontuação de Semelhança</small>
@endif

@if ($item['meanValue'] >= 15 && $item['meanValue'] < 23)
    <small class="badge badge-success"> {{ $item['meanValue'] }} - Média Pontuação de Semelhança</small>
@endif

@if ($item['meanValue'] >= 9 && $item['meanValue'] < 15)
    <small class="badge badge-warning"> {{ $item['meanValue'] }} - Elevada Pontuação de Semelhança</small>
@endif

@if ($item['meanValue'] < 9)
    <small class="badge badge-danger"> {{ $item['meanValue'] }} - Possivelmente Semelhante</small>
@endif
