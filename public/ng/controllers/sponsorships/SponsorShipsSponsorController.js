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
    $scope.sponsor = {
        donor_id:1
    }
    // to reinitialize place errors
    $scope.$watchCollection(
        "object.donor_id",
        (oldData, newData) => {
            $scope.createSponsorShipsSponsor.errors.place_id = null;
        },
        true
    );
    
    $scope.sponsor = {
      donor_id: 1,
      percentage: null,
      purpose_type: "\\App\\Models\\Sponsorship",
      purpose_id: $scope.object.id,
    };
    $scope.add_sponsor = ()=>{
        
        $('#add-sponsors').modal('show');
    }

    $scope.createSponsorShipsSponsor = $apiRequest.config(
      {
        method: "POST",
        url: "sponsors",
        data: $scope.sponsor,
      },
      function (response, data) {}
    );
}
