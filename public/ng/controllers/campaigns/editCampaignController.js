// const { initial } = require("lodash");

async function editCampaignControllerInit($http, $page, $apiRequest) {
    const object = await $apiRequest
        .config("campaigns/" + $page.routeParams.id)
        .getData();
    
    const places = await $apiRequest.config("places").getData();
    // const countries = await $apiRequest.config("countries").getData();

    const init = {
        object: object,
        places: places,
    };

    return init;
}

function editCampaignController($scope, $page, $apiRequest, $init) {
    $scope.object = $init.object;
    $scope.places = $init.places;
    if (!$scope.object.places) $scope.object.places = [];

    $scope.$watchCollection('object.places_ids', (oldData , newData) => {
        $scope.updateCampaign.errors.places_ids = null;
    } , true);


    $scope.updateCampaign = $apiRequest.config(
        {
            method: "PUT",
            url: "campaigns",
            data: $scope.object,
        },
        function (response, data) {}
    );
}
