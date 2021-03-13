async function addCampaignControllerInit($apiRequest) {
    
    let sections = await $apiRequest.config("sections").getData();
    sections.push({id:null , name:"اختر قسم"})

    let init = {
        sections: sections,
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
        funded:false
    };;
    $scope.sections = $init.sections;

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