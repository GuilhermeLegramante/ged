<div>
    @include('partials.modals.form')
</div>
@push('scripts')
<script>
    window.livewire.on('showFolderFormModal', () => {
        $('#folder-form-modal').modal('show');
    });

    window.livewire.on('hideFolderFormModal', () => {
        $('#folder-form-modal').modal('hide');
    });
</script>
@endpush
