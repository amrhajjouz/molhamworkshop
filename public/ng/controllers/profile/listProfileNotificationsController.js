async function listProfileNotificationsControllerInit($datalist, $datalist, $page) {
  return await $datalist(`profile/notifications`).load();
}

function listProfileNotificationsController($scope, $init, $page, $apiRequest) {
    $scope.notifications = $init;
}
