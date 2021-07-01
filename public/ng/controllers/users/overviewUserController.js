function overviewUserControllerInit ($apiRequest, $page) {
    return $apiRequest.config('users/' + $page.routeParams.id).getData();
}

function overviewUserController ($scope, $page, $apiRequest, $init) {
    $scope.user = $init;
    $scope.updateUser = $apiRequest.config({
        method : 'POST',
        url : 'users',
        data : $scope.user,
    }, function (response, data) {
        
    });    
    
}