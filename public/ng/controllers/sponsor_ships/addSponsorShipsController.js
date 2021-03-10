async function addSponsorShipsControllerInit($apiRequest) {
    
    let countries =await  $apiRequest.config("countries").getData();

    let init = {
        countries: countries,
    };

    return init;
}


function addSponsorShipsController($scope, $location, $apiRequest, $page, $init) {
    $scope.object = {};
    $scope.countries = $init.countries;

    $scope.createSponsorShips = $apiRequest.config(
        {
            method: "POST",
            url: "sponsor_ships",
            data: $scope.object,
        },
        function (response, data) {
            $page.navigate("sponsor_ships.overview", { id: data.id });
        }
    );
}