async function listUserActivitiesControllerInit($datalist, $datalist, $page) {
    let activities = await $datalist(`users/${$page.routeParams.id}/activities`).load();

    activities.data.forEach((el) => {
        el.created_at = el.created_at.split('T')[0];
        return el;
    });

    return activities;
}

function listUserActivitiesController($scope, $init, $page, $apiRequest) {
    $scope.activityLogs = $init;

}
