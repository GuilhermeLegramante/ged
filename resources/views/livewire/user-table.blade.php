<div>
    @include('pages.datatable')

    @livewire('user-form-modal', [null, true])
</div>
@push('scripts')
<script>
    window.livewire.on('showUserFormModal', () => {
        $('#user-form-modal').modal('show');
    });

    window.livewire.on('hideUserFormModal', () => {
        $('#user-form-modal').modal('hide');
    });

    window.livewire.on('scrollTop', () => {
        $(window).scrollTop(0);
    });

    $(document).ready(function() {
        $("input").attr("autocomplete", "new-password");
    });

</script>
@endpush
