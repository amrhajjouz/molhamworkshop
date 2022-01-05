function editLeaveControllerInit ($page, $apiRequest) {
    return $apiRequest.config('leaves/' + $page.routeParams.id).getData();
}

function editLeaveController ($scope, $apiRequest, $init) {
   $scope.leave = $init;
      $scope.updateLeave = $apiRequest.config({
          method : 'PUT',
          url : 'leaves',
          data : $scope.leave,
      }, function (response, data) {

      });
}
