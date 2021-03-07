function profilePasswordController ($scope, $apiRequest, $route) {
    
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