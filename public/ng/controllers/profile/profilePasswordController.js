function profilePasswordControllerInit () {
    return ;
}

function profilePasswordController ($scope, $apiRequest, $route) {
    
    /*$scope.changePassword = function () {
        $scope.isChangePasswordSpinnerVisible = true;
        $scope.clearChangePasswordAlert();
        $('body').addClass('cursor-wait');
        $http.post(appApiUrl+'profile/password', $scope.password, {
            headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        }).then(function (response) {
            var apiResponse = response.data;
            if (apiResponse.status == 200) {
                $scope.changePasswordAlert.success = apiResponse.message;
            } else
                $scope.changePasswordAlert.danger = apiResponse.message;
            $scope.isChangePasswordSpinnerVisible = false;
            $('body').removeClass('cursor-wait');
        });
    }*/
    
    $scope.password = {};
    
    $scope.changePassword = $apiRequest.config({
        method : 'POST',
        url : 'profile/password',
        data : $scope.password,
    }, function (response, data) {
        if (data != null && !('error' in data)) {
            alert('تم تغيير كلمة المرور الخاصة بك !');
            $route.reload();
        }
    });
    
}