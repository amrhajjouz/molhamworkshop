var app = angular.module('myApp', []);

app.controller('addEditVolunteerController', function($scope, $http) {

    $scope.isSubmitting = false;
    $scope.isUploadingImage = false;
    $scope.previewImageSource = '';
    $scope.errors = null;
    $scope.volunteer = {};
    
    $scope.init = function () {
        $('body').addClass('cursor-wait');
        $http.get(apiUrl+'countries').then(function(response) {
            var apiResponse = response.data;
            $scope.countries = apiResponse.data.countries;
            $('body').removeClass('cursor-wait');
            $('.page-spinner').addClass('display-none');
            $('.page-content').removeClass('display-none');
        });
    }
    
    $scope.createVolunteer = function () {
        $('body').addClass('cursor-wait');
        $scope.isSubmitting = true;
        $http.post(apiUrl+'volunteers/add', $scope.volunteer).then(function (response) {
            var apiResponse = response.data;
            if (apiResponse.status == 200) {
                location.href = appUrl+'/volunteers/'+apiResponse.data.volunteer.id;
            } else {
                $('body').removeClass('cursor-wait');
                $scope.isSubmitting = false;
                $scope.errors = apiResponse.errors;
                if ($scope.errors != null)
                    $('html, body').animate({scrollTop: $('#'+Object.keys($scope.errors)[0]).offset().top-50}, 500);
            }
        });
    };
    
    $scope.updateVolunteer = function () {
        $('body').addClass('cursor-wait');
        $scope.isSubmitting = true;
        $http.post(apiUrl+'volunteers/edit', $scope.volunteer).then(function (response) {
            var apiResponse = response.data;
            if (apiResponse.status == 200) {
                location.reload();
            } else {
                $('body').removeClass('cursor-wait');
                $scope.isSubmitting = false;
                $scope.errors = apiResponse.errors;
                if ($scope.errors != null)
                    $('html, body').animate({scrollTop: $('#'+Object.keys($scope.errors)[0]).offset().top-50}, 500);
            }
        });
    };
    
    $scope.updateVolunteerPhoto = function () {
        $('body').addClass('cursor-wait');
        $scope.volunteer.photo_image_id = $('#photo_image_id').val();
        $http.post(apiUrl+'volunteers/edit', $scope.volunteer).then(function (response) {
            var apiResponse = response.data;
            if (apiResponse.status == 200) {
                location.reload();
            } else {
                $('body').removeClass('cursor-wait');
                alert(apiResponse.message);
            }
        });
    };

});

/*app.factory('$listQuery', function(url, fields = [], resultsPerPage, ) {
    
    $http.get(url).then(function(response) {
        var apiResponse = response.data;
        $scope.volunteers = apiResponse.data.volunteers;
        $('body').removeClass('cursor-wait');
        $('.page-spinner').addClass('display-none');
        $('.page-content').removeClass('display-none');
    });
    
    return {
        items: []
    };
});*/

app.controller('listVolunteersController', function($scope, $http) {
    
    $scope.volunteers = [];
    $scope.isExporting = false;

    $scope.init = function () {
        $('body').addClass('cursor-wait');
        $http.get(apiUrl+'volunteers').then(function(response) {
            var apiResponse = response.data;
            $scope.volunteers = apiResponse.data.volunteers;
            $('body').removeClass('cursor-wait');
            $('.page-spinner').addClass('display-none');
            $('.page-content').removeClass('display-none');
        });
    }
    
    $scope.export = function () {
        $scope.isExporting = true;
        $('body').addClass('cursor-wait');
        $http.post(apiUrl+'volunteers/export').then(function (response) {
            $scope.isExporting = false;
            $('body').removeClass('cursor-wait');
            var apiResponse = response.data;
            if (apiResponse.status == 200)
                window.location.href = apiResponse.data.file_url;
            else
                alert(apiResponse.message);
        });
    }
    
    $scope.toggleSettings = function () {
        $scope.settingsHidden = !$scope.settingsHidden;
        $('#settings').slideToggle();
    }

    // End Methods have Http Requests //

});

app.controller('listPayrollController', function($scope, $http) {
    
    $scope.payroll = [];
    $scope.settingsHidden = false;
    
    $scope.toggleSettings = function () {
        $scope.settingsHidden = !$scope.settingsHidden;
        $('#settings').slideToggle();
    }
    
    $scope.init = function (volunteerId = 0) {
        $('body').addClass('cursor-wait');
        $http.get(apiUrl+'volunteers/payroll'+((volunteerId != 0) ? '?volunteer_id='+volunteerId : '')).then(function(response) {
            var apiResponse = response.data;
            $scope.payroll = apiResponse.data.payroll;
            for (i=0; i<$scope.payroll.length; i++) {
                $scope.payroll[i].created_at = new Date($scope.payroll[i].created_at);
                $scope.payroll[i].updated_at = new Date($scope.payroll[i].updated_at);
            }
            $('body').removeClass('cursor-wait');
            $('.page-spinner').addClass('display-none');
            $('.page-content').removeClass('display-none');
        });
    }

    // End Methods have Http Requests //

});

app.controller('addToPayrollController', function($scope, $http) {
    
    $scope.volunteers = [];
    $scope.payroll = [];
    
    $scope.init = function () {
        $('body').addClass('cursor-wait');
        $http.get(apiUrl+'volunteers').then(function(response) {
            var apiResponse = response.data;
            $scope.volunteers = apiResponse.data.volunteers;
            $('body').removeClass('cursor-wait');
            $('.page-spinner').addClass('display-none');
            $('.page-content').removeClass('display-none');
        });
    }
    
    

    // End Methods have Http Requests //

});

app.controller('changeAvatarController', function($scope, $http) {
    
    $scope.isSubmitting = false;
    $scope.isUploadingImage = false;
    $scope.avatarImageSource = '';
    $scope.volunteer = {};
    
    $scope.init = function () {
        $('.page-spinner').addClass('display-none');
        $('.page-content').removeClass('display-none');
    }
    

    // End Methods have Http Requests //

});