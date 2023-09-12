<div class="col-md-{{ $columnSize }}">
    <div class="form-group {{ isset($monetaryValue) ? 'text-right' : '' }}">
        <label>{{ $label }}</label>
        <div class="input-group">
            <input wire:model.lazy="{{ $model }}" type="{{ isset($isPassword) ? 'password' : 'text' }}"
                {{ isset($readonly) && $readonly != false ? 'readonly' : '' }}
                @isset($maxLength)
                maxlength="{{ $maxLength }}" @endisset
                class="form-control input-custom {{ isset($monetaryValue) ? 'text-right' : '' }} {{ $errors->has($model) ? 'is-invalid' : '' }}">
        </div>
        @error($model)
            <h3 class="text-danger">
                <strong>{{ $message }}</strong>
            </h3>
        @enderror
    </div>
</div>
