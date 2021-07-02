function editEventControllerInit($page, $apiRequest) {
    return $apiRequest.config('events/' + $page.routeParams.id).getData();
}
function editEventController($scope, $page, $apiRequest, $init) {
    $scope.event = $init;
    $scope.updateEvent = $apiRequest.config(
        {
            method: 'PUT',
            url: 'events',
            data: $scope.event,
        },
        function (response, data) {}
    );
}
