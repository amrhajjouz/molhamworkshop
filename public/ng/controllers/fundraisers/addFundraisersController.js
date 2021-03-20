async function addFundraisersControllerInit($apiRequest) {
    let sections = await $apiRequest.config("sections").getData();
    sections.push({ id: null, name: "اختر قسم" });

    let init = {
        sections: sections,
    };

    return init;
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
            required: 0,
            visible: true,
            documented: false,
            archived: false,
            section_id: null,
        },
    };


        $scope.$watchCollection(
            "object.donor_id",
            (oldData, newData) => {
                $scope.createFundraiser.errors.donor_id = null;
            },
            true
        );

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
