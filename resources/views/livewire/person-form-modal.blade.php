<div>
    @include('partials.modals.form')
</div>
@push('scripts')
<script>
    window.livewire.on('hidePersonFormModal', () => {
        $('#person-form-modal').modal('hide');
    });
</script>
@endpush
