function overviewPublisherControllerInit($apiRequest, $page) {
  return $apiRequest.config("publishers/" + $page.routeParams.id).getData();
}

function overviewPublisherController($scope, $page, $apiRequest, $init) {
  $scope.publisher = $init;
}
