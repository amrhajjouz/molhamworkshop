function overviewUserContractControllerInit ($apiRequest, $page) {
    return $apiRequest.config('user_contracts/' + $page.routeParams.id).getData();
}

function overviewUserContractController ($scope, $init) {
    $scope.userContract = $init;
}
