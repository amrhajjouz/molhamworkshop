function overviewNotificationControllerInit($apiRequest, $page) {
    return $apiRequest.config("notifications_types/" + $page.routeParams.id).getData();
}
function overviewNotificationController($scope, $page, $apiRequest, $init) {
    $scope.notification = $init;
}
