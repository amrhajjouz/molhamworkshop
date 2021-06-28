function editActivityControllerInit($page, $apiRequest) {
    return $apiRequest.config('activities/' + $page.routeParams.id).getData();
}
function editActivityController($scope, $page, $apiRequest, $init) {
    $scope.activity = $init;
    $scope.updateActivity = $apiRequest.config(
        {
            method: 'PUT',
            url: 'activities',
            data: $scope.activity,
        },
        function (response, data) {}
    );
}
