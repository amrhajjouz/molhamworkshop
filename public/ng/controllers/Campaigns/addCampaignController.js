async function addCampaignControllerInit($apiRequest) {
    
    let countries = await $apiRequest.config("countries").getData();

    let init = {
        countries: countries,
    };

    return init;
}


function addCampaignController($scope, $location, $apiRequest, $page, $init) {
    $scope.object = {};
    $scope.countries = $init.countries;

    $scope.createCase = $apiRequest.config(
        {
            method: "POST",
            url: "cases",
            data: $scope.object,
        },
        function (response, data) {
            $page.navigate("cases.overview", { id: data.id });
        }
    );
}