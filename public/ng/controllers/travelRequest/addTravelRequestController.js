function addTravelRequestControllerInit () {
    return [];
}

function addTravelRequestController ($scope, $apiRequest, $page) {

    $scope.travelRequest = {};

    $scope.createTravelRequest = $apiRequest.config({
        method: 'POST',
        url: 'travel_requests',
        data: $scope.travelRequest,
    }, function (response, data) {
        $page.navigate('travel-requests.overview', {id: data.id});
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
