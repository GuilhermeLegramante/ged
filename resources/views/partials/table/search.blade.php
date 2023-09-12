<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label>Busca por {{ $searchFieldsLabel }}</label>
            <div class="input-group">
                <input wire:model.lazy="search" type="text" class="form-control input-custom" placeholder="Pesquisar...">
                @if($insertButtonOnSelectModal)
                <span class="input-group-append">
                    <button class="single-search-btn btn btn-primary" type="button" title="Incluir Registro" wire:click="$emit('{{ $addMethod }}')" {{ isset($disabled) ? ($disabled ? 'disabled' : '') : '' }}><i class="fas fa-plus"></i></button>
                </span>
                @endif
            </div>
        </div>
    </div>

</div>
