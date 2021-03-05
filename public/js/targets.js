var app = angular.module('myApp', []);

app.controller('addEditTargetController', function($scope, $http) {

    $scope.isSubmitting = false;
    $scope.isUploadingImage = false;
    $scope.previewImageSource = '';
    $scope.errors = null;
    $scope.target = {};
    
    $scope.init = function () {
        $('.view-spinner').addClass('display-none');
        $('.view-content').removeClass('display-none');
    }
    
    $scope.createTarget = function () {
        $('body').addClass('cursor-wait');
        $scope.isSubmitting = true;
        $http.post(apiUrl+'targets/add', $scope.target).then(function (response) {
            var apiResponse = response.data;
            if (apiResponse.status == 200) {
                location.href = appUrl+'/targets/'+apiResponse.data.target.id;
            } else {
                $('body').removeClass('cursor-wait');
                $scope.isSubmitting = false;
                $scope.errors = apiResponse.errors;
            }
        });
    };
    
    $scope.updateTarget = function (targetId) {
        $('body').addClass('cursor-wait');
        $scope.isSubmitting = true;
        $http.post(apiUrl+'targets/edit', $scope.target).then(function (response) {
            var apiResponse = response.data;
            if (apiResponse.status == 200) {
                location.reload();
            } else {
                $('body').removeClass('cursor-wait');
                $scope.isSubmitting = false;
                $scope.errors = apiResponse.errors;
            }
        });
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
                    $scope.target.preview_image_id = apiResponse.data.image.id;
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

app.controller('editTargetController', function($scope, $http) {
    
    $scope.isSubmitting = false;
    $scope.errors = null;
    $scope.target = {};
    
    $scope.init = function () {
        $('.view-spinner').addClass('display-none');
        $('.view-content').removeClass('display-none');
    }
    
    $scope.updateTarget = function (targetId) {
        $('body').addClass('cursor-wait');
        $scope.isSubmitting = true;
        $http.post(apiUrl+'targets/edit', $scope.target).then(function (response) {
            var apiResponse = response.data;
            if (apiResponse.status == 200) {
                location.reload();
            } else {
                $('body').removeClass('cursor-wait');
                $scope.isSubmitting = false;
                $scope.errors = apiResponse.errors;
            }
        });
    };
    
});

app.controller('listTargetsController', function($scope, $http) {

    $scope.targets = [];
    $scope.targets_categories = [];
    
    $scope.init = function (targetableType) {
        $('body').addClass('cursor-wait');
        $http.get(apiUrl+'targets?targetable_type='+targetableType).then(function(response) {
            var apiResponse = response.data;
            $scope.targets = apiResponse.data.targets;
            $('body').removeClass('cursor-wait');
            $('.view-spinner').addClass('display-none');
            $('.view-content').removeClass('display-none');
        });
    }

    /*$scope.toggleProductVisibility = function (product) {
        $('body').addClass('cursor-wait');
        $http.post(apiUrl+'targets/edit', product, {
            headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        }).then(function (response) {
            var apiResponse = response.data;
            if (apiResponse.status != 200)
                product.is_visible = !product.is_visible;
            $('body').removeClass('cursor-wait');
        });
    };
    
    $scope.deleteProduct = function (product) {
        var deleteConfirmation = confirm('هل أنت متأكد من حذف هذا المنتج ؟');
        if (deleteConfirmation) {
            $('body').addClass('cursor-wait');
            $http.post(apiUrl+'targets/delete/'+product.id, null, {
                headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            }).then(function (response) {
            var apiResponse = response.data;
                if (apiResponse.status == 200)
                    $scope.targets.splice($scope.targets.findIndex(x => x.id == product.id), 1);
                else
                    alert(apiResponse.message);
                $('body').removeClass('cursor-wait');
            });
        }
    };*/

    // End Methods have Http Requests //

});