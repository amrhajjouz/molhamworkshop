function overviewLeaveTypeControllerInit ($apiRequest, $page) {
    return $apiRequest.config('leave_types/' + $page.routeParams.id).getData();
}

function overviewLeaveTypeController ($scope, $init) {
    $scope.leaveType = $init;
}
