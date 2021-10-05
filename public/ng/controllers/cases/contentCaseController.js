async function contentCaseControllerInit($http, $page, $apiRequest) {
    return {
        case: await $apiRequest.config('programs/medical/cases/' + $page.routeParams.id).getData(),
    };
}

function contentCaseController($scope, $page, $apiRequest, $init) {
    $scope.case = $init.case;
    $scope.case.title = $scope.case.title ? $scope.case.title.ar.value : "";
    $scope.case.description = $scope.case.description ?  $scope.case.description.ar.value : "";
    $scope.case.details = $scope.case.details ? $scope.case.details.ar.value : "";

    $scope.updateCaseContentsRequest = $apiRequest.config(
        {
            method: 'PUT',
            url: `programs/medical/cases/${$scope.case.id}/contents`,
            data: $scope.case,
        },
        function (response, data) {}
    );
}
