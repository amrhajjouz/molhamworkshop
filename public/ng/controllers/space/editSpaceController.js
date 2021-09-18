function editSpaceControllerInit ($page, $apiRequest) {
    return $apiRequest.config('spaces/' + $page.routeParams.id).getData();
}

function editSpaceController ($scope, $apiRequest, $init) {
   $scope.space = $init;
      $scope.updateSpace = $apiRequest.config({
          method : 'PUT',
          url : 'spaces',
          data : $scope.space,
      }, function (response, data) {

      });
}
