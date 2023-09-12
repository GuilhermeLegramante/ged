<div class="col-md-{{ $columnSize }}">
    <div class="form-group">
        <label>{{ $label }}</label>
        <div class="form-group">
            <div wire:ignore>
                <select id="{{ $model }}" {{ isset($multiple) ? 'multiple' : '' }}
                    class="form-control {{ $errors->has($model) ? 'is-invalid' : '' }}" {{ isset($disabled) && $disabled == true ? 'disabled' : '' }} {{ isset($multiple) && $multiple == true ? 'multiple' : '' }}>
                    <option value="">Selecione...</option>
                    @foreach ($options as $item)
                        <option value="{{ $item['value'] }}">{{ $item['description'] }}</option>
                    @endforeach
                </select>
            </div>
            @error($model)
                <h3 class="text-danger">
                    <strong>{{ $message }}</strong>
                </h3>
            @enderror
        </div>
    </div>
</div>