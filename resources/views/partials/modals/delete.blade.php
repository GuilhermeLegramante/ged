<div wire:ignore.self class="modal fade z-index-999999" id="modal-delete" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h3 class="modal-title">ATENÇÃO <i class="fas fa-exclamation-triangle"></i></h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                {{ config('messages.delete.confirmation') }} <br>
                <label>{{ config('messages.delete.confirmation-warning') }}</label>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light btn-sm" data-dismiss="modal" wire:loading.attr="disabled">
                    <i class="fas fa-times" aria-hidden="true"></i>
                    &nbsp; <strong>CANCELAR</strong>
                </button>
                <button type="button" wire:click.prevent="destroy()" class="btn btn-danger btn-sm" wire:key="destroy" wire:loading.attr="disabled">
                    <strong> CONFIRMAR &nbsp;</strong>
                    <i class="fas fa-check" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        window.livewire.on('hideDeleteModal', () => {
            $('#modal-delete').modal('hide');
        });

    </script>
    @endpush
</div>
