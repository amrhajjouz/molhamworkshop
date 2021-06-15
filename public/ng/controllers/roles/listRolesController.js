function listRolesControllerInit($datalist, $location) {
    return $datalist("roles", true).load();
}

function listRolesController($scope, $init, $datalist) {
    $scope.roles = $init;
}
