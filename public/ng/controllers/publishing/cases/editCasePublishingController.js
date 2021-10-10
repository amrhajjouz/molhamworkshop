async function editCasePublishingControllerInit($http, $page, $apiRequest) {
    return {
        case: await $apiRequest.config('publishing/cases/' + $page.routeParams.id).getData(),
    };
}

function editCasePublishingController($scope, $page, $apiRequest, $init) {
    $scope.case = $init.case;

    // temporary just for test contents with en lang
    $scope.case.locale = 'ar'; 
    $scope.case.title = $scope.case.title ? $scope.case.title.ar.value : "";
    $scope.case.description = $scope.case.description ? $scope.case.description.ar.value : "";
    $scope.case.details = $scope.case.details ? $scope.case.details.ar.value :"";

    $scope.updateCaseRequest = $apiRequest.config(
        {
            method: 'PUT',
            url: 'publishing/cases',
            data: $scope.case,
        },
        function (response, data) {}
    );
}
