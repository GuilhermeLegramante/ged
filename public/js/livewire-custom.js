window.livewire.on('scrollTop', () => {
    $(window).scrollTop(0);
});

window.livewire.on('close', () => {
    $('#modal-delete').modal('hide');
});

window.livewire.on('closeModalDelete', () => {
    $('#modal-delete').modal('hide');
});
