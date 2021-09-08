async function addPlaceControllerInit($apiRequest) {

    return {
        countries: await $apiRequest.config("countries").getData(),
    };
}

function addPlaceController($scope, $location, $apiRequest, $page, $init) {
    
    $scope.place = {};
    $scope.countries = $init.countries;
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