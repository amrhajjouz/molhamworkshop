function overviewCasesControllerInit ($apiRequest, $page) {
    return $apiRequest.config('cases/' + $page.routeParams.id).getData();
}

function overviewCasesController ($scope, $page, $apiRequest, $init) {
    
    $scope.object = $init;
    
    $scope.updateUser = $apiRequest.config({
        method : 'POST',
        url : 'cases',
        data : $scope.object,
    }, function (response, data) {
        
    });    
    
}