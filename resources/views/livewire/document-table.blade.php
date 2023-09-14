<div>
    @include('pages.datatable')

    @livewire('document-form-modal')

    @livewire('document-type-form-modal')

</div>
@push('scripts')
<script>
    window.livewire.on('showDocumentFormModal', () => {
        $('#document-form-modal').modal('show');
    });

    window.livewire.on('hideDocumentFormModal', () => {
        $('#document-form-modal').modal('hide');
    });

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
