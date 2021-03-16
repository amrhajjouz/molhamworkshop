function overviewPlacesControllerInit ($apiRequest, $page) {
    return $apiRequest.config('places/' + $page.routeParams.id).getData();
}

function overviewPlacesController ($scope, $page, $apiRequest, $init) {
    
    $scope.object = $init;

    
}