<div>
    @include('partials.modals.form')

    @livewire('document-type-select')

</div>
@push('scripts')
<script>
    window.livewire.on('hideDemandFormModal', () => {
        $('#{{ $entity }}-form-modal').modal('hide');
    });

    window.livewire.on('showDocumentTypeSelectModal', () => {
        $('#modal-select-document-type').modal('show');
        Livewire.emit('documentTypeSelectModal');
    });

</script>
@endpush
