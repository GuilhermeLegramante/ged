@if(count($model) > 0)
<div class="col-md-{{ $columnSize }}">
    <div class="form-group">
        <label>{{ $label }}</label>
        <div class="input-group">
            @foreach ($headerColumns as $item)
            @if(isset($item['field']))
            <div class="mr-1" wire:click="showHideColumn(`{{ $item['field'] }}`)">
                <small class="cursor-pointer badge {{ $item['visible'] ? 'badge-primary' : 'badge-light' }}  mt-1">{{ $item['label'] }} </small>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</div>
@endif
