
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

    $scope.updateFundraiser = $apiRequest.config(
        {
            method: "PUT",
            url: "fundraisers",
            data: $scope.object,
        },
        function (response, data) {}
    );
}
