function overviewLeaveControllerInit ($apiRequest, $page) {
    return $apiRequest.config('leaves/' + $page.routeParams.id).getData();
}

function overviewLeaveController ($scope, $init) {
    $scope.leave = $init;
}
