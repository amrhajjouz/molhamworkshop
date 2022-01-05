function listLeaveTypeControllerInit ($page, $datalist) {
    return $datalist('leave_types', true).load();
}

function listLeaveTypeController ($scope, $init) {
   $scope.leaveTypes = $init;
}
