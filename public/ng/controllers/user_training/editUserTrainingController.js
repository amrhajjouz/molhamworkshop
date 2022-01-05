function editUserTrainingControllerInit ($page, $apiRequest) {
    return $apiRequest.config('user_trainings/' + $page.routeParams.id).getData();
}

function editUserTrainingController ($scope, $apiRequest, $init) {
   $scope.userTraining = $init;
      $scope.updateUserTraining = $apiRequest.config({
          method : 'PUT',
          url : 'user_trainings',
          data : $scope.userTraining,
      }, function (response, data) {

      });
}
