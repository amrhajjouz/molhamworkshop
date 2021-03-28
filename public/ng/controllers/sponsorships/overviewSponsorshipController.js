function overviewSponsorshipControllerInit ($apiRequest, $page) {
    return $apiRequest.config('sponsorships/' + $page.routeParams.id).getData();
}

function overviewSponsorshipController ($scope, $page, $apiRequest, $init) {
    
    $scope.object = $init;

    
}