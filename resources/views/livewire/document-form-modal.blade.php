<div>
    @include('partials.modals.form')

    @livewire('document-type-select')

    @livewire('person-select')

</div>
@push('scripts')
<script>
    window.livewire.on('hideDocumentFormModal', () => {
        $('#document-form-modal').modal('hide');
    });

    window.livewire.on('showDocumentTypeSelectModal', () => {
        $('#modal-select-document-type').modal('show');
        Livewire.emit('documentTypeSelectModal');
    });

    window.livewire.on('showPersonSelectModal', () => {
        $('#modal-select-person').modal('show');
        Livewire.emit('personSelectModal');
    });

</script>
@endpush
