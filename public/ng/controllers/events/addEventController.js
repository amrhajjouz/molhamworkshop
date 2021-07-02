function addEventController($scope, $apiRequest, $page) {
    $scope.event = {};
    $scope.createEvent = $apiRequest.config(
        {
            method: 'POST',
            url: 'events',
            data: $scope.event,
        },
        function (response, data) {
            $page.navigate('events.overview', { id: data.id });
        }
    );
}
