<div class="col-md-{{ $columnSize }}">
    <div class="form-group">
        <label>{{ $label }}</label>
        <div class="form-group">
            <div class="input-group">
                <input wire:model="{{ $model }}" type="color" class="form-control input-custom {{ $errors->has($model) ? 'is-invalid' : '' }} {{ isset($readonly) ? ($readonly != false ? 'readonly' : '') : '' }}">
            </div>
            @error($model)
            <h3 class="text-danger">
                <strong>{{ $message }}</strong>
            </h3>
            @enderror
        </div>
    </div>
</div>
