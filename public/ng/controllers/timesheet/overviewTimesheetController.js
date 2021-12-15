function overviewTimesheetControllerInit ($page, $datalist) {
    return $datalist('timesheet/single/' + $page.routeParams.id, true).load();
}

function overviewTimesheetController ($scope, $init, $apiRequest, $page) {
    $scope.records = $init;
    let data = $apiRequest.config('users/' + $page.routeParams.id).getData();;
    console.log(data);
    $scope.user_data = data;
}
