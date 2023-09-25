<div>
    @include('pages.datatable')

    @livewire('document-type-form-modal', [null, true])
</div>
@push('scripts')
<script>
    window.livewire.on('showDocumentTypeFormModal', () => {
        $('#document-type-form-modal').modal('show');
    });

    window.livewire.on('hideDocumentTypeFormModal', () => {
        $('#document-type-form-modal').modal('hide');
    });

    window.livewire.on('scrollTop', () => {
        $(window).scrollTop(0);
    });

</script>
@endpush
