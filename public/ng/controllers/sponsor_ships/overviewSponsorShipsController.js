function overviewSponsorShipsControllerInit ($apiRequest, $page) {
    return $apiRequest.config('sponsor_ships/' + $page.routeParams.id).getData();
}

function overviewSponsorShipsController ($scope, $page, $apiRequest, $init) {
    
    $scope.object = $init;

        // $scope.object.beneficiary_birthdate = new Date(
        //     $scope.object.beneficiary_birthdate
        // );

    
    // $scope.updatSponsorShip = $apiRequest.config({
    //     method : 'POST',
    //     url : 'sponsor_ships',
    //     data : $scope.object,
    // }, function (response, data) {
        
    // });    
    
}