<div class="row mt-2">
    <div class="col-md-12 text-center">
        <a wire:ignore href="{{ route($basePath) }}" class="btn btn-outline-primary btn-sm"
            wire:loading.class="disabled">
            <i class="fas fa-times" aria-hidden="true"></i>
            <strong> CANCELAR &nbsp;</strong>
        </a>
        <button wire:click.prevent="report" wire:key="report" type="submit"
            wire:loading.attr="disabled" class="btn btn-primary btn-sm">
            <strong> GERAR RELATÓRIO &nbsp;</strong>
            <i class="fas fa-file-pdf" aria-hidden="true"></i>
        </button>
    </div>
</div>
