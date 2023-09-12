<thead>
    <tr class="cursor-pointer">
        @foreach ($headerColumns as $item)
        @if(isset($item['visible']) && $item['visible'] == 'true')
        @if ($item['field'])
        <th wire:click="sortBy('{{ $item['field'] }}')" class=" {{ isset($item['css']) ? $item['css'] : '' }}">
            @else
        <th class=" {{ isset($item['css']) ? $item['css'] : '' }}">
            @endif
            @if ($item['label'] == 'checkbox')
            <input class="w-100" type="checkbox" wire:model="checkAll">
            @else
            {{ $item['label'] }}
            @endif
            @isset($item['field'])
            @if ($sortBy !== $item['field'])
            <i style="color: lightgray" class="fas fa-arrow-up fa-xs"></i>
            <i style="color: lightgray" class="fas fa-arrow-down fa-xs"></i>
            @elseif ($sortDirection == 'asc')
            <i style="color: black" class="fas fa-arrow-up fa-xs"></i>
            <i style="color: lightgray" class="fas fa-arrow-down fa-xs"></i>
            @else
            <i style="color: lightgray" class="fas fa-arrow-up fa-xs"></i>
            <i style="color: black" class="fas fa-arrow-down fa-xs"></i>
            @endif
            @endisset
        </th>
        @endif
        @endforeach
    </tr>
</thead>
