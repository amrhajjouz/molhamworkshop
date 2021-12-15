function listTimesheetControllerInit ($page, $datalist) {
    return $datalist('users', true).load();
}

function listTimesheetController ($scope, $init) {
   $scope.users = $init;
}
