
async function editFundraisersControllerInit($http, $page, $apiRequest) {
    const object = await $apiRequest
        .config("fundraisers/" + $page.routeParams.id)
        .getData();

  let sections = await $apiRequest.config("sections").getData();

    const init = {
        object: object,
        sections: sections,
    };
    return init;
}

function editFundraisersController($scope, $page, $apiRequest, $init) {
    $scope.object = $init.object;
    $scope.sections = $init.sections;



    $scope.$watchCollection(
        "object.donor_id",
        (oldData, newData) => {
            $scope.updateFundraiser.errors.donor_id = null;
        },
        true
    );

    $scope.updateFundraiser = $apiRequest.config(
        {
            method: "PUT",
            url: "fundraisers",
            data: $scope.object,
        },
        function (response, data) {}
    );
}
