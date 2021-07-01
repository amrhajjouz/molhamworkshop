function listUsersControllerInit ($datalist, $location) {
    return $datalist('users', true).load();
}

function listUsersController ($scope, $init, $datalist) {
    $scope.users = $init;
}
