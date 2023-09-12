<div class="col-md-{{ $columnSize }}">
    <div class="form-group">
        <label>{{ $label }}</label>
        <div class="input-group">
            <input wire:model.lazy="{{ $model }}" type="number" {{ isset($max) ? 'max=' . $max : '' }} {{ isset($min) ? 'min=' . $min : '' }} class="form-control input-custom {{ $errors->has($model) ? 'is-invalid' : '' }}" {{ isset($readonly) && $readonly != false ? 'readonly' : '' }}>
        </div>
        @error($model)
        <h3 class="text-danger">
            <strong>{{ $message }}</strong>
        </h3>
        @enderror
    </div>
</div>
