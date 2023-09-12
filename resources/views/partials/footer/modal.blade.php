<div class="modal-footer">
    <button type="button" class="btn btn-outline-primary btn-sm" data-dismiss="modal" wire:loading.attr="disabled">
        <i class="fas fa-times" aria-hidden="true"></i>
        <strong> CANCELAR &nbsp;</strong>
    </button>
    <button wire:click.prevent="{{ $method }}" wire:key="{{ $method }}" type="submit" wire:loading.attr="disabled" class="btn btn-primary btn-sm">
        <strong> SALVAR &nbsp;</strong>
        <i class="fas fa-save" aria-hidden="true"></i>
    </button>
    @if ($method == 'update')
    <button data-toggle="modal" data-toggle="tooltip" data-placement="top" title="Excluir o registro" data-target="#modal-delete" class="btn btn-outline-danger btn-sm" wire:key="delete" wire:loading.attr="disabled">
        <strong> EXCLUIR &nbsp;</strong>
        <i class="fas fa-trash-alt"></i>
    </button>
    @endif
</div>
