function addTaskControllerInit () {
    return [];
}

function addTaskController ($scope, $apiRequest, $page) {

    $scope.task = {};

    $scope.createTask = $apiRequest.config({
        method: 'POST',
        url: 'tasks',
        data: $scope.task,
    }, function (response, data) {
        $page.navigate('tasks.overview', {id: data.id});
    });
}
