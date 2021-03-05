function profileInfoControllerInit ($http, $page, $apiRequest) {
    return $apiRequest.config('auth').getData();
    
    //return $promissesWrap({auth: auth, list:});
}

function profileInfoController ($scope, $http, $location, $init, $route, $apiRequest) {
    
    $scope.auth = $init;
    
    /*$scope.isProfileUpdating = false;
    
    $scope.updateProfile = function () {
        $scope.isProfileUpdating = true;
        $http.post(apiUrl+'profile', $scope.profile).then(function (response) {
            //$scope.response = response;
            var apiResponse = response.data;
            if ('error' in apiResponse) {
                alert(apiResponse.error);
            } else {
                
                //$route.reload();
            }
            $scope.isProfileUpdating = false;
        }, function (response) {
            $scope.response = response;
        });
    }*/
    
    $scope.profile = {};
    
    $scope.updateProfile = $apiRequest.config({
        method : 'POST',
        url : 'profile',
        data : $scope.profile,
    }, function (response, data) {
        $('.auth-name').text($scope.profile.name);
    });
    
    //$scope.updateProfile.send();
    
}