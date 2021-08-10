function editApiErrorControllerInit ($page, $apiRequest) {
    return $apiRequest.config('api_errors/' + $page.routeParams.id).getData();
}
function editApiErrorController ($scope, $page, $apiRequest, $init) {
    $scope.apiError = $init;
    $scope.updateApiError = $apiRequest.config({
        method : 'PUT',
        url : 'api_errors',
        data : $scope.apiError,
    }, function (response, data) {

    });
}
