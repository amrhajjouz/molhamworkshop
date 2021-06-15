function overviewRoleControllerInit ($apiRequest, $page) {
    return $apiRequest.config('roles/' + $page.routeParams.id).getData();
}
function overviewRoleController ($scope, $page, $apiRequest, $init) {
    $scope.role = $init;
}
