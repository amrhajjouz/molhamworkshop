function editUserResidenceControllerInit ($page, $apiRequest) {
    return $apiRequest.config('user_residences/' + $page.routeParams.id).getData();
}

function editUserResidenceController ($scope, $apiRequest, $init) {
   $scope.userResidence = $init;
      $scope.updateUserResidence = $apiRequest.config({
          method : 'PUT',
          url : 'user_residences',
          data : $scope.userResidence,
      }, function (response, data) {

      });
}
