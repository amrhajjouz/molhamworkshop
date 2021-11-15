function overViewUserResidenceControllerInit ($apiRequest, $page) {
    return $apiRequest.config('user_residences/' + $page.routeParams.id).getData();
}

function overviewUserResidenceController ($scope, $init) {
    $scope.userResidence = $init;
}
