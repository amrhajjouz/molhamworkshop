function editUserFamilyMemberControllerInit ($page, $apiRequest) {
    return $apiRequest.config('user_family_members/' + $page.routeParams.id).getData();
}

function editUserFamilyMemberController ($scope, $apiRequest, $init) {
   $scope.userFamilyMember = $init;
      $scope.updateUserFamilyMember = $apiRequest.config({
          method : 'PUT',
          url : 'user_family_members',
          data : $scope.userFamilyMember,
      }, function (response, data) {

      });
}
