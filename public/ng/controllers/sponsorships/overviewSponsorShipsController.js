function overviewSponsorShipsControllerInit ($apiRequest, $page) {
    return $apiRequest.config('sponsorships/' + $page.routeParams.id).getData();
}

function overviewSponsorShipsController ($scope, $page, $apiRequest, $init) {
    
    $scope.object = $init;

    
}