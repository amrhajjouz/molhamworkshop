function addApiErrorController($scope, $apiRequest, $page) {
    $scope.apiError = { status: 400, code: null, message: { ar: null, en: null } };
    $scope.createApiError = $apiRequest.config({
        method: 'POST',
        url: 'api_errors',
        data: $scope.apiError,
    }, function (response, data) {
        $page.navigate('apiErrors.overview', { id: data.id });
    });

}
