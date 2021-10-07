async function editCaseTranslationControllerInit($http, $page, $apiRequest) {
    return {
        case: await $apiRequest.config('translation/cases/' + $page.routeParams.id).getData(),
    };
}

function editCaseTranslationController($scope, $page, $apiRequest, $init) {
    $scope.case = $init.case;

    // temporary just for test contents with en lang
    $scope.case.locale = 'en'; 
    $scope.case.title = $scope.case.title.en ? $scope.case.title.en.value : '';
    $scope.case.description = $scope.case.description.en ? $scope.case.description.en.value : '';
    $scope.case.details = $scope.case.details.en ? $scope.case.details.en.value : '';

    $scope.updateCaseTranslationRequest = $apiRequest.config(
        {
            method: 'PUT',
            url: 'translation/cases',
            data: $scope.case,
        },
        function (response, data) {}
    );
}
