function profileInfoControllerInit ($apiRequest) {
    return $apiRequest.config('auth').getData();
}

function profileInfoController ($scope, $init, $apiRequest) {
    
    $scope.auth = $init;
    $scope.profile = $init;
    
    $scope.updateProfile = $apiRequest.config({
        method : 'POST',
        url : 'profile',
        data : $scope.profile,
    }, function (response, data) {
    });
    
}