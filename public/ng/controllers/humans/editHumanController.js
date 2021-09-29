function editHumanControllerInit ($page, $apiRequest) {
    return $apiRequest.config('humans/' + $page.routeParams.id).getData();
}

function editHumanController ($scope, $apiRequest, $init) {

      $scope.human = $init;

      $scope.updateHuman = $apiRequest.config({
          method : 'PUT',
          url : 'humans',
          data : $scope.human,
      }, function (response, data) {

      });
}
