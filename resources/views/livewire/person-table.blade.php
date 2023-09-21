<div>
    @include('pages.datatable')

    @livewire('person-form-modal')
</div>
@push('scripts')
<script>
    window.livewire.on('showPersonFormModal', () => {
        $('#person-form-modal').modal('show');
    });

    window.livewire.on('hidePersonFormModal', () => {
        $('#person-form-modal').modal('hide');
    });

    window.livewire.on('scrollTop', () => {
        $(window).scrollTop(0);
    });
</script>
@endpush
