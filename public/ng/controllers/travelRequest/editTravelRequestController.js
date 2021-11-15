function editTravelRequestControllerInit ($page, $apiRequest) {
    return $apiRequest.config('travel_requests/' + $page.routeParams.id).getData();
}

function editTravelRequestController ($scope, $apiRequest, $init) {

    $scope.travelRequest = $init;

    $scope.updateTravelRequest = $apiRequest.config({
      method : 'PUT',
      url : 'travel_requests',
      data : $scope.travelRequest,
    }, function (response, data) {

    });

    let fillFinancialCompensation
    $scope.fillFinancialCompensation = function (destination,travel) {
        if(destination === 'syria' || travel === 'car'){
            fillFinancialCompensation = [50,10,100,300];
        }else if (travel === 'train') {
            fillFinancialCompensation = [500,100,333,56];
        }
        $scope.travelRequest.total_food_allowance = fillFinancialCompensation[0];
        $scope.travelRequest.total_subsistence_allowance = fillFinancialCompensation[1];
        $scope.travelRequest.total_transportation_allowance = fillFinancialCompensation[2];
        $scope.travelRequest.travel_compensation = fillFinancialCompensation[3];
    }

}
