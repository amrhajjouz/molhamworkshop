function addNotificationController($scope, $apiRequest, $page) {
    $scope.notification = {};
    $scope.createNotification = $apiRequest.config(
        {
            method: "POST",
            url: "notifications_types",
            data: $scope.notification,
        },
        function (response, data) {
            $page.navigate("notifications.overview", { id: data.id });
        }
    );
}
