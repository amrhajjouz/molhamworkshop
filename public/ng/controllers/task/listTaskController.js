function listTaskControllerInit ($page, $datalist) {
    return $datalist('tasks', true).load();
}

function listTaskController ($scope, $init) {
   $scope.tasks = $init;
}
