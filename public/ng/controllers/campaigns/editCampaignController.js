// const { initial } = require("lodash");

async function editCampaignControllerInit($http, $page, $apiRequest) {
    const object = await $apiRequest
        .config("campaigns/" + $page.routeParams.id)
        .getData();

    // const countries = await $apiRequest.config("countries").getData();

    // const init = {
    //     object: object,
    //     countries: countries,
    // };
    return object;
}

function editCampaignController($scope, $page, $apiRequest, $init) {
    $scope.object = $init;

    $scope.updateCampaign = $apiRequest.config(
        {
            method: "PUT",
            url: "campaigns",
            data: $scope.object,
        },
        function (response, data) {}
    );
}
