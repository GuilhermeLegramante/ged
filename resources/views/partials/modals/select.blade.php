<div wire:ignore.self class="modal fade z-index-99999" id="{{ $modalId }}" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <p><strong>{{ $title }}</strong></p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body">
                @include('partials.spinner.default')
                @include('partials.table.search')

                <div class="maxh-300px table-responsive">
                    <table class="pd-dot3r table table-hover table-striped">
                        @include('partials.table.header')

                        @include('partials.table.body')
                    </table>
                </div>
            </div>

            @include('partials.table.modal-links')

            @if ($type == 'multiple')
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary btn-sm" data-dismiss="modal" wire:loading.attr="disabled">
                    <i class="fas fa-times" aria-hidden="true"></i>
                    <strong> CANCELAR &nbsp;</strong>
                </button>
                <button wire:click.prevent="selectMultiple" wire:key="selectMultiple" type="submit" wire:loading.attr="disabled" class="btn btn-primary btn-sm">
                    <strong> CONFIRMAR &nbsp;</strong>
                    <i class="fas fa-check" aria-hidden="true"></i>
                </button>
            </div>
            @endif
        </div>
    </div>
</div>
