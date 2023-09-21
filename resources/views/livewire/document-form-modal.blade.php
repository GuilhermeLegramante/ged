<div>
    @include('partials.modals.form')

    @livewire('document-type-select')

    @livewire('person-select')

    @livewire('person-form-modal')
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

    window.livewire.on('showPersonFormModal', () => {
        $('#person-form-modal').modal('show');
    });

    window.livewire.on('hidePersonFormModal', () => {
        $('#person-form-modal').modal('hide');
    });

</script>
@endpush
