function overviewTravelRequestControllerInit ($apiRequest, $page) {
    return $apiRequest.config('travel_requests/' + $page.routeParams.id).getData();
}

function overviewTravelRequestController ($scope, $page, $apiRequest, $init) {

    $scope.travelRequest = $init;

    $scope.updateTravelRequest = $apiRequest.config({
        method : 'POST',
        url : 'travel_requests',
        data : $scope.travelRequest,
    }, function (response, data) {

    });
}
