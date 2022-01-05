function editUserLanguageControllerInit ($page, $apiRequest) {
    return $apiRequest.config('user_languages/' + $page.routeParams.id).getData();
}

function editUserLanguageController ($scope, $apiRequest, $init) {
   $scope.userLanguage = $init;
      $scope.updateUserLanguage = $apiRequest.config({
          method : 'PUT',
          url : 'user_languages',
          data : $scope.userLanguage,
      }, function (response, data) {

      });
}
