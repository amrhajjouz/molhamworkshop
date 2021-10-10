async function editCaseControllerInit($http, $page, $apiRequest) {
    return {
        case: await $apiRequest.config('programs/medical/cases/' + $page.routeParams.id).getData(),
    };
}

function editCaseController($scope, $page, $apiRequest, $init) {
    $scope.case = $init.case;

    $scope.updateCaseRequest = $apiRequest.config(
        {
            method: 'PUT',
            url: 'programs/medical/cases',
            data: $scope.case,
        },
        function (response, data) {}
    );
}
