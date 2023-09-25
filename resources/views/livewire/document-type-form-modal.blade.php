<div>
    @include('partials.modals.form')
</div>
@push('scripts')
<script>
    window.livewire.on('showDocumentTypeFormModal', () => {
        $('#document-type-form-modal').modal('show');
    });

    window.livewire.on('hideDocumentTypeFormModal', () => {
        $('#document-type-form-modal').modal('hide');
    });

</script>
@endpush
