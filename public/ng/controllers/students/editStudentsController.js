
async function editStudentsControllerInit($http, $page, $apiRequest) {
    const object = await $apiRequest
        .config("students/" + $page.routeParams.id)
        .getData();

    const countries = await $apiRequest.config("countries").getData();

    const init = {
        object: object,
        countries: countries,
    };
    return init;
}

function editStudentsController($scope, $page, $apiRequest, $init) {
    $scope.object = $init.object;
    $scope.countries = $init.countries;

    $scope.updateStudent = $apiRequest.config(
        {
            method: "PUT",
            url: "students",
            data: $scope.object,
        },
        function (response, data) {}
    );
}
