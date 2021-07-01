async function listUserLogsControllerInit($datalist, $datalist, $page) {
    let activities = await $datalist(`users/${$page.routeParams.id}/activity_logs`).load();
    activities.data.forEach((el) => {el.created_at = el.created_at.split('T')[0];return el;});
    return activities;
}

function listUserLogsController($scope, $init, $page, $apiRequest) {
    $scope.activityLogs = $init;
}
