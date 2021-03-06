function listUsersControllerInit ($apiRequest) {
    return $apiRequest.config('users').getData();
}

function listUsersController ($scope, $http, $location, $init) {
    
    $scope.users = $init;
}