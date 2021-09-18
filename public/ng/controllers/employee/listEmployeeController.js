function listEmployeeControllerInit ($page, $datalist) {
    return $datalist('employees', true).load();
}

function listEmployeeController ($scope, $init) {
   $scope.employees = $init;
}
