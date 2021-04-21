function overviewEventControllerInit($apiRequest, $page) {
  return $apiRequest.config("events/" + $page.routeParams.id).getData();
}

function overviewEventController($scope, $page, $apiRequest, $init) {
  $scope.object = $init;

}
