<div class="col-md-{{ $columnSize }}">
    <div class="form-group">
        <label>{{ $label }}</label>
        <div class="form-group">
            <div class="input-group">
                @if (isset($disabled) && $disabled)
                <input type="text" class="form-control input-custom" value="{{ substr($description, 0, 100) }}" disabled>
                @else
                <h3 wire:click="$emit('{{ $method }}')" class="cursor-pointer form-control input-custom {{ $errors->has($model) ? 'is-invalid' : '' }}">
                    {{ substr($description, 0, 100) }}</h3>
                @endif

                <span class="input-group-append">
                    <button type="button" class="btn btn-primary" title="Pesquisar" wire:click="$emit('{{ $method }}')" {{ isset($disabled) ? ($disabled ? 'disabled' : '') : '' }}>
                        <i class="fas fa-search"></i>
                    </button>
                </span>
                @isset($cleanFields)
                <span class="input-group-append">
                    <button wire:click="cleanFields(`{{ $cleanFields }}`)" class="single-search-btn btn btn-outline-primary" type="button" title="Limpar" {{ isset($disabled) ? ($disabled ? 'disabled' : '') : '' }}>
                        <i class="fas fa-times"></i>
                    </button>
                </span>
                @endisset
                @isset($addMethod)
                <span class="input-group-append">
                    <button class="single-search-btn btn btn-info" type="button" title="Incluir Registro" wire:click="$emit('{{ $addMethod }}')" {{ isset($disabled) ? ($disabled ? 'disabled' : '') : '' }}><i class="fas fa-plus"></i></button>
                </span>
                @endisset
                @isset($editMethod)
                <span class="input-group-append">
                    <button class="single-search-btn btn btn-secondary" type="button" title="Editar Registro" wire:click="$emit('{{ $editMethod }}', '{{ $modelId }}')" {{ isset($disabled) ? ($disabled ? 'disabled' : '') : '' }}><i class="fas fa-edit"></i></button>
                </span>
                @endisset
            </div>
            @error($model)
            <h3 class="text-danger">
                <strong>{{ $message }}</strong>
            </h3>
            @enderror
        </div>
    </div>
</div>
