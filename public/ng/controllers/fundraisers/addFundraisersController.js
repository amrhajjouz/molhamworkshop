async function addFundraisersControllerInit($apiRequest) {

    let init = {
    };

    return init;
}


function addFundraisersController($scope, $location, $apiRequest, $page, $init) {
    $scope.object = {
        public_visibility: false,
        verified: false,
        target: {
            required: 0,
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