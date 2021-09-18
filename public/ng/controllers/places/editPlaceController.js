async function editPlaceControllerInit($http, $page, $apiRequest) {
    return await $apiRequest.config("places/" + $page.routeParams.id).getData();
}

function editPlaceController($scope, $page, $apiRequest, $init) {
    $scope.place = $init;
    $scope.updatePlace = $apiRequest.config({ method: "PUT", url: "places", data: $scope.place, }, function (response, data) { });
}
