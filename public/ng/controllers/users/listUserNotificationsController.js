async function listUserNotificationsControllerInit($datalist, $datalist, $page) {
    return await $datalist(`users/${$page.routeParams.id}/notifications`).load();
}

function listUserNotificationsController($scope, $init, $page, $apiRequest) {
    $scope.notifications = $init;
}
