function editUserSkillControllerInit ($page, $apiRequest) {
    return $apiRequest.config('user_skills/' + $page.routeParams.id).getData();
}

function editUserSkillController ($scope, $apiRequest, $init) {
   $scope.userSkill = $init;
      $scope.updateUserSkill = $apiRequest.config({
          method : 'PUT',
          url : 'user_skills',
          data : $scope.userSkill,
      }, function (response, data) {

      });
}
