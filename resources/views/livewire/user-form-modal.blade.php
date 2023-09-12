<div>
    @include('partials.modals.form')
</div>
@push('scripts')
<script>
    window.livewire.on('hideDemandFormModal', () => {
        $('#{{ $entity }}-form-modal').modal('hide');
    });
    $(document).ready(function() {
        $("input").attr("autocomplete", "new-password");
    });

</script>
@endpush
