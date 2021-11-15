function editUserSectionControllerInit ($page, $apiRequest) {
    return $apiRequest.config('user_sections/' + $page.routeParams.id).getData();
}

function editUserSectionController ($scope, $apiRequest, $init) {
   $scope.userSection = $init;
      $scope.updateUserSection = $apiRequest.config({
          method : 'PUT',
          url : 'user_sections',
          data : $scope.userSection,
      }, function (response, data) {

      });
}
