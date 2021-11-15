function editUserContactDatumControllerInit ($page, $apiRequest) {
    return $apiRequest.config('user_contact_data/' + $page.routeParams.id).getData();
}

function editUserContactDatumController ($scope, $apiRequest, $init) {
   $scope.userContactDatum = $init;
      $scope.updateUserContactDatum = $apiRequest.config({
          method : 'PUT',
          url : 'user_contact_data',
          data : $scope.userContactDatum,
      }, function (response, data) {

      });
}
