<div class="row mt-2">
    <div class="col-md-12 text-center">
        @if($hasPreviewData)
        <button wire:click.prevent="viewData()" type="submit" wire:loading.class="disabled" class="btn btn-primary btn-sm">
            <strong> VISUALIZAR DADOS &nbsp;</strong>
            <i class="fas fa-search" aria-hidden="true"></i>
        </button>
        @endif
        @if($hasPdfReport)
        <button wire:click.prevent="report()" type="submit" wire:loading.class="disabled" class="btn btn-primary btn-sm">
            <strong> RELATÓRIO EM PDF &nbsp;</strong>
            <i class="fas fa-file-pdf" aria-hidden="true"></i>
        </button>
        @endif
    </div>
</div>
