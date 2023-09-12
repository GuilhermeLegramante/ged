<div class="col-md-{{ $columnSize }}">
    <div class="form-group">
        <label>{{ $label }}</label>
        <textarea wire:model="{{ $model }}" rows="{{ $rows }}"
            maxlength="{{ $maxLength }} {{ isset($readonly) ? ($readonly != false ? 'readonly' : '') : '' }}"
            class="form-control input-custom {{ $errors->has($model) ? 'is-invalid' : '' }}">
        </textarea>
        @error($model)
            <h3 class="text-danger">
                <strong>{{ $message }}</strong>
            </h3>
        @enderror
    </div>
</div>
