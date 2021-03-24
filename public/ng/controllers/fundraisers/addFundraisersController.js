async function addFundraisersControllerInit($apiRequest) {
    
    
    return{
        sections:await $apiRequest.config("sections").getData()
    } 

}

function addFundraisersController(
    $scope,
    $location,
    $apiRequest,
    $page,
    $init
) {

    $scope.sections = $init.sections;
    
    $scope.object = {
        public_visibility: false,
        verified: false,
        donor_id:null,
        target: {
            required: 1,
            visible: true,
            documented: false,
            archived: false,
            section_id: null,
        },
    };


    $scope.createFundraiser = $apiRequest.config(
        {
            method: "POST",
            url: "fundraisers",
            data: $scope.object,
        },
        function (response, data) {
            $page.navigate("fundraisers.overview", { id: data.id });
        }
    );
}
