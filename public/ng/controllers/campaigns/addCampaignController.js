async function addCampaignControllerInit($apiRequest) {
    

    return {
      sections: await $apiRequest.config("sections").getData(),
      places: await $apiRequest.config("places").getData(),
    };


}


function addCampaignController($scope, $location, $apiRequest, $page, $init) {
    
    $scope.object = {
        target: {
            beneficiaries_count: 1,
            required: 1,
            visible: true,

            documented: false,
            archived: false,
            section_id: null,
        },
        places: [],
        funded: false,
    };
    $scope.sections = $init.sections;
    $scope.places = $init.places;


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