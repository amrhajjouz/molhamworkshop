function editUserContractControllerInit ($page, $apiRequest) {
    return $apiRequest.config('user_contracts/' + $page.routeParams.id).getData();
}

function editUserContractController ($scope, $apiRequest, $init) {
   $scope.userContract = $init;
      $scope.updateUserContract = $apiRequest.config({
          method : 'PUT',
          url : 'user_contracts',
          data : $scope.userContract,
      }, function (response, data) {

      });
}
