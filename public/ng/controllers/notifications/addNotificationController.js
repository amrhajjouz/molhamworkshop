function addNotificationController($scope, $apiRequest, $page) {
    $scope.notification = {body:{ar:null , en:null}};
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
