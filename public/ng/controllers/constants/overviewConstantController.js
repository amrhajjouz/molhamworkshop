function overviewConstantControllerInit($apiRequest, $page) {
  return $apiRequest.config("constants/" + $page.routeParams.id).getData();
}

function overviewConstantController($scope, $page, $apiRequest, $init) {
  $scope.constant = $init;
}
