
async function editFundraiserControllerInit($http, $page, $apiRequest) {


    return {
      object: (object = await $apiRequest
        .config("fundraisers/" + $page.routeParams.id)
        .getData()),
      sections: await $apiRequest.config("sections").getData(),
    };
}

function editFundraiserController($scope, $page, $apiRequest, $init) {
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
