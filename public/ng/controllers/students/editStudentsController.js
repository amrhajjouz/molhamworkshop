async function editStudentsControllerInit($http, $page, $apiRequest) {
    const object = await $apiRequest
        .config("students/" + $page.routeParams.id)
        .getData();

    const countries = await $apiRequest.config("countries").getData();
    const places = await $apiRequest.config("places").getData();

    const init = {
        object: object,
        countries: countries,
        places: places,
    };
    return init;
}



function editStudentsController($scope, $page, $apiRequest, $init) {
    $scope.countries = $init.countries;
    $scope.places = $init.places;
    $scope.object = $init.object;

    if (!$scope.object.places) $scope.object.places = [];

    // to reinitialize place errors
    $scope.$watchCollection(
        "object.place_id",
        (oldData, newData) => {
            $scope.updateStudent.errors.place_id = null;
        },
        true
    );

    $scope.updateStudent = $apiRequest.config(
        {
            method: "PUT",
            url: "students",
            data: $scope.object,
        },
        function (response, data) {}
    );
}
