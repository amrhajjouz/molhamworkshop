async function editPlaceControllerInit($http, $page, $apiRequest) {
    const place = await $apiRequest.config("places/" + $page.routeParams.id).getData();
    
    return {
        place: place,
    };
}

function editPlaceController($scope, $page, $apiRequest, $init) {
    
    $scope.place = $init.place;

    $scope.updatePlace = $apiRequest.config({
        method: "PUT",
        url: "places",
        data: $scope.place,
    }, function (response, data) {});
}
