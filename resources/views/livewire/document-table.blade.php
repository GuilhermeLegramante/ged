<div>
    @include('pages.datatable')

    @livewire('document-form-modal')
</div>
@push('scripts')
<script>
    window.livewire.on('showDocumentFormModal', () => {
        $('#document-form-modal').modal('show');
    });

    window.livewire.on('hideDocumentFormModal', () => {
        $('#document-form-modal').modal('hide');
    });

    window.livewire.on('scrollTop', () => {
        $(window).scrollTop(0);
    });
</script>
@endpush
