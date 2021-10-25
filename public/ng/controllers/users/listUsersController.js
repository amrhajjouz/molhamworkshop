function listUsersControllerInit ($datalist) {
    return $datalist('users', true).load();
}

function listUsersController ($scope, $init) {
    $scope.users = $init;
}
