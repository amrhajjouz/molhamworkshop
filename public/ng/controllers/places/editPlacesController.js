// const { initial } = require("lodash");

async function editPlacesControllerInit($http, $page, $apiRequest) {
    const object = await $apiRequest
        .config("places/" + $page.routeParams.id)
        .getData();

    const countries = await $apiRequest.config("countries").getData();

    const init = {
        object: object,
        countries: countries,
    };
    return init;
}

function editPlacesController($scope, $page, $apiRequest, $init) {

       $scope.types = [
           { id: "province", name: "محافظة" },
           { id: "city", name: "مدينة" },
           { id: "district", name: "منطقة" },
           { id: "village", name: "قرية" },
       ];


    $scope.object = $init.object;
    $scope.countries = $init.countries;
    
    
    $scope.updatePlace = $apiRequest.config(
        {
            method: "PUT",
            url: "places",
            data: $scope.object,
        },
        function (response, data) {}
    );
}
