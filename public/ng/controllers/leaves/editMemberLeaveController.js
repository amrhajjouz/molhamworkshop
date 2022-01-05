function editMemberLeaveControllerInit ($page, $apiRequest) {
    return $apiRequest.config('members/leaves/' + $page.routeParams.id).getData();
}

function editMemberLeaveController ($scope, $apiRequest, $init) {
   $scope.leave = $init;
      $scope.updateLeave = $apiRequest.config({
          method : 'PUT',
          url : 'members/leaves',
          data : $scope.leave,
      }, function (response, data) {

      });
}
