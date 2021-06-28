function overviewActivityControllerInit($apiRequest, $page) {
    return $apiRequest.config('activities/' + $page.routeParams.id).getData();
}
function overviewActivityController($scope, $page, $apiRequest, $init) {
    $scope.activity = $init;
}
