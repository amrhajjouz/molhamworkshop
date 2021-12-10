function editTeamOfficeControllerInit ($page, $apiRequest) {
    return $apiRequest.config('team_offices/' + $page.routeParams.id).getData();
}

function editTeamOfficeController ($scope, $apiRequest, $init) {
   $scope.teamOffice = $init;
      $scope.updateTeamOffice = $apiRequest.config({
          method : 'PUT',
          url : 'team_offices',
          data : $scope.teamOffice,
      }, function (response, data) {

      });
}
