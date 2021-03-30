function listFundraisersControllerInit($datalist) {
  return $datalist("fundraisers", true).load();
}

function listFundraisersController($scope, $init) {
  $scope.fundraisers = $init;
}
