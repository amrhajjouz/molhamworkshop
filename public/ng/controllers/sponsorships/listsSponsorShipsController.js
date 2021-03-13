function listsSponsorShipsControllerInit($apiRequest) {
    return $apiRequest.config("sponsorships").getData();
}

function listsSponsorShipsController($scope, $init) {
    
    $scope.sponsorships = $init;
}