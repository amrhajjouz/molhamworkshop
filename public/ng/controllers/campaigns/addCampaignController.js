// async function addCampaignControllerInit($apiRequest) {
    
//     let countries = await $apiRequest.config("countries").getData();

//     let init = {
//         countries: countries,
//     };

//     return init;
// }


function addCampaignController($scope, $location, $apiRequest, $page, $init) {
    $scope.object = {};

    $scope.createCampaign = $apiRequest.config(
        {
            method: "POST",
            url: "campaigns",
            data: $scope.object,
        },
        function (response, data) {
            $page.navigate("campaigns.overview", { id: data.id });
        }
    );
}