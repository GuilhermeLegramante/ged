<div>
    @include('pages.datatable')

    @include('partials.modals.document-filter')

    @livewire('document-form-modal', [null, true])

    @livewire('document-type-form-modal')

    @livewire('folder-form-modal')

    @livewire('document-type-select')

    @livewire('folder-select')

    @livewire('person-select')

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

    window.livewire.on('showDocumentFilterModal', () => {
        $('#document-filter-modal').modal('show');
    });

    window.livewire.on('hideDocumentFilterModal', () => {
        $('#document-filter-modal').modal('hide');
    });

    window.livewire.on('showDocumentTypeSelectModal', () => {
        $('#modal-select-document-type').modal('show');
        Livewire.emit('documentTypeSelectModal');
    });

    window.livewire.on('showFolderSelectModal', () => {
        $('#modal-select-folder').modal('show');
        Livewire.emit('folderSelectModal');
    });

    window.livewire.on('showPersonSelectModal', () => {
        $('#modal-select-person').modal('show');
        Livewire.emit('personSelectModal');
    });

    window.livewire.on('showFolderFormModal', () => {
        $('#folder-form-modal').modal('show');
    });

    window.livewire.on('hideFolderFormModal', () => {
        $('#folder-form-modal').modal('hide');
    });

</script>
@endpush
