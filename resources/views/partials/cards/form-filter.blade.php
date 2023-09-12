<div wire:ignore.self class="card card-primary card-outline">
    <div class="card-header" data-card-widget="collapse">
        <div class="row mt-1">
            <div class="col-md-4">
                <h3 class="card-title cardTitleCustom"><strong> DADOS DO FORMULÁRIO</strong>
                </h3>
            </div>
        </div>
        <div class="card-tools mt-n2">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        @include($formPath)
    </div>
    <div class="card-footer">
        <div class="col-md-12 text-center">
            <button wire:click.prevent="send" wire:key="send" type="submit" wire:loading.attr="disabled" class="btn btn-primary btn-sm">
                <strong> ENVIAR &nbsp;</strong>
                <i class="fas fa-paper-plane" aria-hidden="true"></i>
            </button>
        </div>
    </div>
</div>
