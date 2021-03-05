var app = angular.module('myApp', []);

app.controller('addEditPostController', function($scope, $http) {

    $scope.isSubmitting = false;
    $scope.isUploadingImage = false;
    $scope.previewImageSource = '';
    $scope.errors = null;
    $scope.post = {};
    
    $scope.init = function () {
        $('.view-spinner').addClass('display-none');
        $('.view-content').removeClass('display-none');
    }
    
    $scope.createPost = function () {
        var editorText = quill.getText();
        if (editorText != '') {
            $scope.post.body_ar = quill.container.firstChild.innerHTML;
            $('body').addClass('cursor-wait');
            $scope.isSubmitting = true;
            $http.post(apiUrl+'posts/add', $scope.post).then(function (response) {
                var apiResponse = response.data;
                if (apiResponse.status == 200) {
                    location.href = appUrl+'/posts/'+apiResponse.data.post.id;
                } else {
                    $('body').removeClass('cursor-wait');
                    $scope.isSubmitting = false;
                    $scope.errors = apiResponse.errors;
                    alert(apiResponse.message);
                }
            });
        } else {
            alert('لا يمكنك اضافة منشور فارغ !');
        }
    };
    
    $scope.updatePost = function () {
        var editorText = quill.getText();
        if (editorText != '') {
            $scope.post.body_ar = quill.container.firstChild.innerHTML;
            $('body').addClass('cursor-wait');
            $scope.isSubmitting = true;
            $http.post(apiUrl+'posts/edit', $scope.post).then(function (response) {
                var apiResponse = response.data;
                if (apiResponse.status == 200) {
                    location.reload();
                } else {
                    $('body').removeClass('cursor-wait');
                    $scope.isSubmitting = false;
                    $scope.errors = apiResponse.errors;
                }
            });
        } else {
            alert('لا يمكنك تعديل منشور فارغ !');
        }
    };
    
    $scope.uploadImage = function (file) {
        var reader = new FileReader();
        reader.onload = function () {
            $('body').addClass('cursor-wait');
            $scope.isUploadingImage = true;
            $scope.form = {data_url: reader.result};
            $http.post(apiUrl+'images/upload', $scope.form, {
                uploadEventHandlers: {
                    progress: function (e) {
                        if (e.lengthComputable) {
                            $scope.progressBarPercentage = (e.loaded / e.total) * 100;
                            $scope.$apply();
                        }
                    }
                }
            }).then(function (response) {
                var apiResponse = response.data;
                if (apiResponse.status == 200) {
                    $scope.previewImageSource = apiResponse.data.image.url.image;
                    $scope.post.preview_image_id = apiResponse.data.image.id;
                } else {
                    alert(apiResponse.messsage);
                }
                $('body').removeClass('cursor-wait');
                $scope.isUploadingImage = false;
                $scope.progressBarPercentage = 0;
            });
            $scope.$apply();
        }
        reader.readAsDataURL(file);
    }

});

app.controller('listPostsController', function($scope, $http) {

    $scope.posts = [];
    $scope.posts_categories = [];
    
    $scope.init = function () {
        $('body').addClass('cursor-wait');
        $http.get(apiUrl+'posts').then(function(response) {
            var apiResponse = response.data;
            $scope.posts = apiResponse.data.posts;
            $('body').removeClass('cursor-wait');
            $('.view-spinner').addClass('display-none');
            $('.view-content').removeClass('display-none');
        });
    }

    // End Methods have Http Requests //

});