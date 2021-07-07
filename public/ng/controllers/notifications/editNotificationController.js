function editNotificationControllerInit($page, $apiRequest) {
    return $apiRequest.config("notifications_types/" + $page.routeParams.id).getData();
}
function editNotificationController($scope, $page, $apiRequest, $init) {
    $scope.notification = $init;
    $scope.updateNotification = $apiRequest.config(
        {
            method: "PUT",
            url: "notifications_types",
            data: $scope.notification,
        },
        function (response, data) {}
    );
}
