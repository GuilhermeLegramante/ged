@include('partials.modals.delete')

<div wire:ignore.self class="modal fade z-index-99999" id="{{ $entity }}-form-modal" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <p>
                    <i class="{{ $icon }}"></i>
                    <strong>{{ $pageTitle }}</strong>
                </p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body">
                @include('partials.flash-messages.default')

                @include('partials.spinner.default')

                @include('partials.forms.' . "$entity")

                <div class="modal-footer">
                    @include('partials.buttons.form-actions')
                </div>
            </div>
        </div>
    </div>
</div>
