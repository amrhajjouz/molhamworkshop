function listTasksControllerInit($page, $datalist) {
    return $datalist("tasks", true).load();
}

function listTasksController($scope, $init) {
    $scope.tasks = $init;
}
