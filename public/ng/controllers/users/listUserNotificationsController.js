async function listUserNotificationsControllerInit($datalist, $datalist, $page) {
    let notifications = await $datalist(`users/${$page.routeParams.id}/notifications`).load();
    notifications.data.forEach((el) => {
        el.created_at = el.created_at.split('T')[0];
        if(el.read_at)el.read_at =  el.read_at.split("T")[0];
        return el;
    });

     return notifications;
}

function listUserNotificationsController($scope, $init, $page, $apiRequest) {
    $scope.notifications = $init;
}
