<div class="col-md-{{ $columnSize }}">
    <div class="form-group">
        <label>{{ $label }}</label>
        <div class="form-group">
            <div class="input-group">
                <input wire:model="{{ $model }}" type="{{ isset($isDatetime) ? 'datetime-local' : 'date' }}" @if(isset($max)) max="{{ $max }}" @else max='9999-12-31' @endif class="form-control input-custom {{ $errors->has($model) ? 'is-invalid' : '' }} {{ isset($readonly) ? ($readonly != false ? 'readonly' : '') : '' }}">
            </div>
            @error($model)
            <h3 class="text-danger">
                <strong>{{ $message }}</strong>
            </h3>
            @enderror
        </div>
    </div>
</div>
