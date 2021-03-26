// const { initial } = require("lodash");

async function editSponsorshipsControllerInit($http, $page, $apiRequest) {
    const object = await $apiRequest
        .config("sponsorships/" + $page.routeParams.id)
        .getData();
    object.beneficiary_birthdate = new Date(object.beneficiary_birthdate);

    const countries = await $apiRequest.config("countries").getData();
    const places = await $apiRequest.config("places").getData();

    const init = {
        object: object,
        countries: countries,
        places: places,
    };
    return init;
}



function editSponsorshipsController($scope, $page, $apiRequest, $init) {
    $scope.object = $init.object;
    $scope.countries = $init.countries;
    $scope.places = $init.places;

    $scope.updateSponsorShips = $apiRequest.config(
        {
            method: "PUT",
            url: "sponsorships",
            data: $scope.object,
        },
        function (response, data) {}
    );
}
