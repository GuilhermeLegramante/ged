<div>
    @include('pages.datatable')

    @livewire('folder-form-modal', [null, true])
</div>
@push('scripts')
<script>
    window.livewire.on('showFolderFormModal', () => {
        $('#folder-form-modal').modal('show');
    });

    window.livewire.on('hideFolderFormModal', () => {
        $('#folder-form-modal').modal('hide');
    });

    window.livewire.on('scrollTop', () => {
        $(window).scrollTop(0);
    });

</script>
@endpush
