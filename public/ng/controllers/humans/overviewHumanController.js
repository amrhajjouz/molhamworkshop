function overViewHumanControllerInit ($apiRequest, $page) {
    return $apiRequest.config('humans/' + $page.routeParams.id).getData();
}

function overviewHumanController ($scope, $init) {
    $scope.human = $init;
}
