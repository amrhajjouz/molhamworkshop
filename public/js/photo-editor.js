function showPhotoEditorModal () {
    $('#photo-editor-modal').modal('show');
}

var imageFile = document.getElementById('image-file');
var editorImage = document.getElementById('editor-image');
var editorResultImage = document.getElementById('editor-result-image');
var cropBoxData;
var canvasData;
var cropper;
var aspectRatio;
var imageIdSelector;

function setPhotoEditorImage (file) {
    var reader = new FileReader();
    reader.onload = function () {
        editorImage.src = reader.result;
        cropper = new Cropper(editorImage, {
            autoCropArea: 0.5,
            aspectRatio:aspectRatio,
            dragMode: 'move',
            minCropBoxWidth:512,
            minCropBoxHeight:512,
            ready: function() {
                cropper.setCropBoxData(cropBoxData).setCanvasData(canvasData);
            }
        });
        $('#photo-editor #select-file-container').addClass('display-none');
        $('#photo-editor #editor-container').removeClass('display-none');
    }
    reader.readAsDataURL(file);
}

function clearPhotoEditor () {
    $('#photo-editor #select-file-container').removeClass('display-none');
    $('#photo-editor #editor-container').addClass('display-none');
    $('#photo-editor #result-container').addClass('display-none');
    cropBoxData = cropper.getCropBoxData();
    canvasData = cropper.getCanvasData();
    cropper.destroy();
    imageFile.value = null;
}

function showPhotoEditorResult () {
    editorResultImage.src = cropper.getCroppedCanvas().toDataURL('image/jpeg');
    $('#photo-editor #editor-container').addClass('display-none');
    $('#photo-editor #result-container').removeClass('display-none');
}

function showPhotoEditor () {
    $('#photo-editor #editor-container').removeClass('display-none');
    $('#photo-editor #result-container').addClass('display-none');
}

function uploadEditedPhoto () {
    const formData = new FormData();
    formData.append('image', editorResultImage.src);
    $.ajax(apiUrl+'images/upload/single', {
        type: 'post',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: formData,
        dataType: 'json',
        cache:false,
        contentType: false,
        processData: false,
        beforeSend: function () {
            $('#photo-editor #result-container #result-options').addClass('display-none');
            $('#photo-editor #result-container #upload-spinner').removeClass('display-none');
        },
        success: function (response) {
            if (response.status == 200) {
                $(imageIdSelector).val(response.data.image.id).trigger('change');;
                $('#photo-editor-modal').modal('hide');
                clearPhotoEditor();
            } else {
                alert('هناك خطأ ما غير معروف !');
            }
            $('#photo-editor #result-container #result-options').removeClass('display-none');
            $('#photo-editor #result-container #upload-spinner').addClass('display-none');
        },
        error: function () {
            alert('هناك خطأ ما !! الرجاء اعادة المحاولة او اخبار المسؤول عن ذلك !');
        },
    });
}

window.addEventListener('DOMContentLoaded', function() {
    $('#photo-editor-modal').on('hidden.bs.modal', function() {
        clearPhotoEditor();
    });
});
