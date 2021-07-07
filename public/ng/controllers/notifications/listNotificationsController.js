function listNotificationsControllerInit($datalist, $location) {
    return $datalist("notifications_types", true).load();
}
function listNotificationsController($scope, $init, $datalist) {
    $scope.notifications = $init;
}
