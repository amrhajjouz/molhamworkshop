function overViewTaskControllerInit ($apiRequest, $page) {
    return $apiRequest.config('tasks/' + $page.routeParams.id).getData();
}

function overviewTaskController ($scope, $init) {
    $scope.task = $init;
}
