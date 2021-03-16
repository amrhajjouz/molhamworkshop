async function addCampaignControllerInit($apiRequest) {
    
    const sections = await $apiRequest.config("sections").getData();
    sections.push({id:null , name:"اختر قسم"})

    const places = await $apiRequest.config("places").getData();

    const init = {
        sections: sections,
        places: places,
    };


    return init;
}


function addCampaignController($scope, $location, $apiRequest, $page, $init) {
    $scope.object = {
        target: {
            beneficiaries_count: 0,
            required: 0,
            visible: true,

            documented: false,
            archived: false,
            section_id: null,
        },
        places:[],
        funded:false
    };;
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