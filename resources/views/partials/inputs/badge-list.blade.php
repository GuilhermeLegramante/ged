@if(count($model) > 0)
<div class="col-md-{{ $columnSize }}">
    <div class="form-group">
        <label>{{ $label }}</label>
        <div class="input-group flex-wrap">
            @foreach ($model as $key => $item)
            <div class="mr-1 d-inline-block" style="white-space: normal;" wire:click="removeTag({{ $key }})">
                <small class="cursor-pointer badge badge-primary mt-1">
                    {{ $item }}
                    <small>
                        <i class="fas fa-times"></i>
                    </small>
                </small>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif
