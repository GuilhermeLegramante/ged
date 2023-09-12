<tbody>
    @foreach ($data as $item)
    @if (isset($selectModal) && $type == 'single')
    <tr data-dismiss="modal" wire:click="$emit('{{ $selectModal }}', '{{ $item->id }}')" class="cursor-pointer">
        @else
    <tr>
        @endif
        @foreach ($bodyColumns as $column)
        @if(isset($column['visible']) && $column['visible'] == 'true')

        <td class="{{ isset($column['css']) ? $column['css'] : '' }} align-middle">
            @switch($column['type'])
            @case('string')
            <div wire:click="enableFieldEdition(`{{ $item->id }}`, `{{ $column['field'] }}`, `{{ $item->{$column['field']} }}`)">

                @if($item->id == $fieldIdInEdition && $column['field'] == $columnNameInEdition && $column['editable'] == 'true')
                <input class="form-control input-custom" type="text" wire:model.lazy='valueInEdition'>
                @else
                {{ $item->{$column['field']} }}
                @endif
            </div>
            @break

            @case('timestamps')
            {{ date('d/m/Y H:i:s', strtotime($item->{$column['field']})) }}
            @break

            @case('date')
            {{ date('d/m/Y', strtotime($item->{$column['field']})) }}
            @break

            @case('year')
            {{ date('Y', strtotime($item->{$column['field']})) }}
            @break

            @case('monetary')
            {{ number_format($item->{$column['field']}, 2, ',', '.') }}
            @break

            @case('image')
            @if($item->{$column['field']} != '')
            <img class="img" onerror="this.onerror=null; this.src='img/no-preview.jpg'" src="{{ Storage::disk('s3')->url($item->{$column['field']}) }}" style="width: 30px; height: 30px;">
            @else
            <img class="img" onerror="this.onerror=null; this.src='img/no-preview.jpg'" src="img/no-preview.jpg" style="width: 30px; height: 30px;">
            @endif
            @break

            @case('checkbox')
            <input class="w-100" type="checkbox" wire:model="selected.{{ $item->{$column['field']} }}" value="{{ $item->{$column['label']} }}">
            @break

            @case('boolean')
            @if ($item->{$column['field']} == 1)
            <i class="fas fa-check"></i>
            @endif
            @break

            @case('color')
            <small style="background-color: {{ $item->{$column['field']} }}" class="badge badge-danger">
                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
            </small>
            {{-- {{ $item->{$column['field']} }} --}}
            @break

            @case('availablePosts')
            <span style="font-size: 95%;" class="right badge {{ $item->{$column['field']} < 1 ? 'badge-danger' : 'badge-success' }}">
                {{ $item->{$column['field']} }}
            </span>
            @break

            @endswitch
        </td>
        @endif
        @endforeach
        @if (isset($modalActionButtons))
        @foreach ($modalActionButtons as $button)
        <td>
            <div class="input-group pl-12px align-middle {{ isset($column['css']) ? $column['css'] : '' }}">
                @include($button['view'])
            </div>
        </td>
        @endforeach
        @else
        @if (isset($buttons))
        {{-- <td class="align-middle text-center">
                    <div class="input-group justify-content-center">
                        @foreach ($buttons as $button)
                            @if (is_array($button))
                                @include($button['view'])
                            @else
                                @include($button->view)
                            @endif
                        @endforeach
                    </div>
                </td> --}}
        <td class="align-middle text-center">
            <button type="button" class="btn btn-primary dropdown-toggle dropdown-icon w-80" data-toggle="dropdown" aria-expanded="false">
            </button>
            <div class="dropdown-menu" style="">
                @foreach ($buttons as $button)
                <a wire:click="{{ $button->method }}({{ $item->id }})" class="dropdown-item" href="#"><i class="{{ $button->icon }}"></i> {{ $button->title }}</a>
                @endforeach
            </div>
        </td>
        @endif
        @endif
    </tr>
    @endforeach
</tbody>
