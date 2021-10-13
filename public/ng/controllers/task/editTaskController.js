function editTaskControllerInit ($page, $apiRequest) {
    return $apiRequest.config('tasks/' + $page.routeParams.id).getData();
}

function editTaskController ($scope, $apiRequest, $init) {
   $scope.task = $init;
      $scope.updateTask = $apiRequest.config({
          method : 'PUT',
          url : 'tasks',
          data : $scope.task,
      }, function (response, data) {

      });
}
