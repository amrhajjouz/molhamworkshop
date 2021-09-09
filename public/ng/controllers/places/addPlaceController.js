async function addPlaceControllerInit($apiRequest) {

}

function addPlaceController($scope, $location, $apiRequest, $page, $init) {

    $scope.place = {};
    $scope.parentPlaces = [];

    $scope.createPlace = $apiRequest.config({
        method: "POST",
        url: "places",
        data: $scope.place
    }, function (response, data) {
        $page.navigate("places.overview", {
            id: data.id
        });
    });
}