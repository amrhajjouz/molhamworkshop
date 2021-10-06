$(function () {
  $('[data-bs-toggle="tooltip"]').tooltip()
});


function showImageLightboxModal (src) {
    if (src != '') {
        $('#image-lightbox-modal img').attr('src', src);
        $('#image-lightbox-modal').modal('show');
    }
}