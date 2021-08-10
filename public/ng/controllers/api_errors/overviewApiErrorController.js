function overviewApiErrorControllerInit ($apiRequest, $page) {
    return $apiRequest.config('api_errors/' + $page.routeParams.id).getData();
}
function overviewApiErrorController ($scope, $page, $apiRequest, $init) {
    $scope.apiError = $init;
}
