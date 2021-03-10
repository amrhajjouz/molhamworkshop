function listsSponsorShipsControllerInit($apiRequest) {
    return $apiRequest.config("sponsor_ships").getData();
}

function listsSponsorShipsController($scope, $init) {
    
    $scope.sponsor_ships = $init;
}