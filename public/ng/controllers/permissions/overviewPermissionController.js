function overviewPermissionControllerInit($apiRequest, $page) {
    return $apiRequest.config("permissions/" + $page.routeParams.id).getData();
}
function overviewPermissionController($scope, $page, $apiRequest, $init) {
    $scope.permission = $init;
}
