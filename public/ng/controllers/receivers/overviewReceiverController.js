function overviewReceiverControllerInit ($apiRequest, $page) {
    return $apiRequest.config('receivers/' + $page.routeParams.id).getData();
}
function overviewReceiverController ($scope, $page, $apiRequest, $init) {
    $scope.receiver = $init;
}
