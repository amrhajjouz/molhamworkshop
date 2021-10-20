
function listFilesController($scope, $init) {

    /* Dropzone */
    const toggles = document.querySelectorAll('[data-dropzone]');

    toggles.forEach((toggle) => {
        let currentFile = undefined;

        const elementOptions = toggle.dataset.dropzone ? JSON.parse(toggle.dataset.dropzone) : {};

        const defaultOptions = {
            previewsContainer: toggle.querySelector('.dz-preview'),
            previewTemplate: toggle.querySelector('.dz-preview').innerHTML,
            init: function () {
                this.on('addedfile', function (file) {
                    const maxFiles = elementOptions.maxFiles;

                    if (maxFiles == 1 && currentFile) {
                        this.removeFile(currentFile);
                    }

                    currentFile = file;
                });
            },
        };

        const options = {
            ...elementOptions,
            ...defaultOptions,
        };

        // Clear preview
        toggle.querySelector('.dz-preview').innerHTML = '';

        // Init dropzone
        new Dropzone(toggle, options);
    });

    /* Cropper */
    const image = document.getElementById('cropper');
    const cropper = new Cropper(image, {
        initialAspectRatio: 16 / 9,
        aspectRatio: 16 / 9,
        crop(event) {
            console.log(event.detail.x);
            console.log(event.detail.y);
            console.log(event.detail.width);
            console.log(event.detail.height);
            console.log(event.detail.rotate);
            console.log(event.detail.scaleX);
            console.log(event.detail.scaleY);
        },
    });
}