async function listProfileNotificationsControllerInit($datalist, $datalist, $page) {
    let notifications = await $datalist(`profile/notifications`).load();
    notifications.data.forEach((el) => {el.created_at = el.created_at.split('T')[0];return el;});
     return notifications;
}

function listProfileNotificationsController($scope, $init, $page, $apiRequest) {
    $scope.notifications = $init;
}
