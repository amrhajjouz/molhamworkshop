function listPlacesControllerInit($apiRequest) {
    return $apiRequest.config("places").getData();
}

function listPlacesController($scope, $init) {
    
    $scope.places = $init;
}