function componentsController($scope, $init) {
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

    /* Toasts */

    $("#myBtn1").click(function(){
        $("#myToast1").toast("show");
    });
    
    $("#myBtn2").click(function(){
        $("#myToast2").toast("show");
    });
}
