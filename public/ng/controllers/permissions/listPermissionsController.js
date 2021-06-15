function listPermissionsControllerInit($datalist, $location) {
    return $datalist("permissions", true).load();
}

function listPermissionsController($scope, $init, $datalist) {
    $scope.permissions = $init;
}
