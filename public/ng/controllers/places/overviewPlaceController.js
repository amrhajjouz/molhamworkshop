function overviewPlaceControllerInit($apiRequest, $page) {
  return $apiRequest.config("places/" + $page.routeParams.id).getData();
}

function overviewPlaceController($scope, $page, $apiRequest, $init) {
  $scope.object = $init;
}
