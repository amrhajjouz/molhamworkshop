function editUserWorkExperienceControllerInit ($page, $apiRequest) {
    return $apiRequest.config('user_work_experiences/' + $page.routeParams.id).getData();
}

function editUserWorkExperienceController ($scope, $apiRequest, $init) {
   $scope.userWorkExperience = $init;
      $scope.updateUserWorkExperience = $apiRequest.config({
          method : 'PUT',
          url : 'user_work_experiences',
          data : $scope.userWorkExperience,
      }, function (response, data) {

      });
}
