
async function editFundraisersControllerInit($http, $page, $apiRequest) {
    const object = await $apiRequest
        .config("fundraisers/" + $page.routeParams.id)
        .getData();


    const init = {
        object: object,
    };
    return init;
}

function editFundraisersController($scope, $page, $apiRequest, $init) {
    $scope.object = $init.object;

    $scope.updateEvent = $apiRequest.config(
        {
            method: "PUT",
            url: "fundraisers",
            data: $scope.object,
        },
        function (response, data) {}
    );
}
