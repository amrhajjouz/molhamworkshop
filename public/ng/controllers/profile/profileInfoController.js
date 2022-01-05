function profileInfoControllerInit ($apiRequest) {
    console.log($apiRequest.config('auth').getData())
    return $apiRequest.config('auth').getData();
}

function profileInfoController ($scope, $init, $apiRequest) {
    
    $scope.auth = $init;
    
    $scope.profile = {};
    
    $scope.updateProfile = $apiRequest.config({
        method : 'POST',
        url : 'profile',
        data : $scope.profile,
    }, function (response, data) {
        if (data != null && !('error' in data)) {
            alert('تم تحديث البيانات الشخصية !');
            $route.reload();
        }
    });
    
}