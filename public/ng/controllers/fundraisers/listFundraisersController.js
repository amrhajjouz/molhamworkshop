function listFundraisersControllerInit($apiRequest) {
  return $apiRequest.config("fundraisers").getData();
}

function listFundraisersController($scope, $init) {
  $scope.fundraisers = $init;
}
