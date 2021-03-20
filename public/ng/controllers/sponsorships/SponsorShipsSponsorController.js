// const { initial } = require("lodash");

async function SponsorShipsSponsorControllerInit($http, $page, $apiRequest) {
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



function SponsorShipsSponsorController($scope, $page, $apiRequest, $init) {
    $scope.object = $init.object;
    $scope.countries = $init.countries;
    $scope.places = $init.places;

    // to reinitialize place errors
    $scope.$watchCollection(
        "object.place_id",
        (oldData, newData) => {
            $scope.updateSponsorShips.errors.place_id = null;
        },
        true
    );
    
    $scope.updateSponsorShips = $apiRequest.config(
        {
            method: "PUT",
            url: "sponsorships",
            data: $scope.object,
        },
        function (response, data) {}
    );
}
