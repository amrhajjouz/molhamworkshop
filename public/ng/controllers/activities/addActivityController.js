function addActivityController($scope, $apiRequest, $page) {
    $scope.activity = {};
    $scope.createActivity = $apiRequest.config(
        {
            method: 'POST',
            url: 'activities',
            data: $scope.activity,
        },
        function (response, data) {
            $page.navigate('activities.overview', { id: data.id });
        }
    );
}
