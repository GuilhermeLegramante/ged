window.addEventListener('livewire:load', () => {
    document.querySelector('input').focus()
})

var showModal = '<?php echo $showModal; ?>';
window.livewire.on(showModal, () => {
    let idModal = '<?php echo "#" . $idModal; ?>';
    $(idModal).modal('show');
})
window.livewire.on('delete', () => {
    $('#modal-delete').modal('show');
})