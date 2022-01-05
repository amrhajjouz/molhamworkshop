function editLeaveTypeControllerInit ($page, $apiRequest) {
    return $apiRequest.config('leave_types/' + $page.routeParams.id).getData();
}

function editLeaveTypeController ($scope, $apiRequest, $init) {
   $scope.leaveType = $init;
      $scope.updateLeaveType = $apiRequest.config({
          method : 'PUT',
          url : 'leave_types',
          data : $scope.leaveType,
      }, function (response, data) {

      });
}
