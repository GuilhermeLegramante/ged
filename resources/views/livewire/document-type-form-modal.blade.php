<div>
    @include('partials.modals.form')
</div>
@push('scripts')
<script>
    window.livewire.on('hideDemandFormModal', () => {
        $('#{{ $entity }}-form-modal').modal('hide');
    });
</script>
@endpush
