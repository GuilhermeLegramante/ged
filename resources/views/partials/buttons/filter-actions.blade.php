<a href="" data-dismiss="modal" class="btn btn-outline-primary btn-sm" wire:loading.class="disabled">
    <i class="fas fa-times" aria-hidden="true"></i>
    <strong> CANCELAR &nbsp;</strong>
</a>
<button data-dismiss="modal" wire:click.prevent="setFilters()" wire:key="setFilters" type="submit" wire:loading.attr="disabled" class="btn btn-primary btn-sm">
    <strong> SALVAR &nbsp;</strong>
    <i class="fas fa-save" aria-hidden="true"></i>
</button>
