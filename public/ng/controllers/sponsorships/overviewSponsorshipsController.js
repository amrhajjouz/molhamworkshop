function overviewSponsorshipsControllerInit ($apiRequest, $page) {
    return $apiRequest.config('sponsorships/' + $page.routeParams.id).getData();
}

function overviewSponsorshipsController ($scope, $page, $apiRequest, $init) {
    
    $scope.object = $init;

    
}