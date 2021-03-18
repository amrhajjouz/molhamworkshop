function listUsersControllerInit ($apiRequest) {
    return $apiRequest.config('users').getData();
}

function listUsersController ($scope, $init) {

    $scope.users = $init;
}
