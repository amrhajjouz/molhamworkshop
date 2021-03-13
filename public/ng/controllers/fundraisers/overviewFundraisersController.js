function overviewFundraisersControllerInit ($apiRequest, $page) {
    return $apiRequest.config('fundraisers/' + $page.routeParams.id).getData();
}

function overviewFundraisersController ($scope, $page, $apiRequest, $init) {
    
    $scope.object = $init;
    
    $scope.updateEvent = $apiRequest.config({
        method : 'POST',
        url : 'fundraisers',
        data : $scope.object,
    }, function (response, data) {
        
    });    
    
}