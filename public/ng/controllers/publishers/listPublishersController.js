function listPublishersControllerInit($datalist) {
  return $datalist("publishers", true).load();
}

function listPublishersController($scope, $init) {
  $scope.publishers = $init;
}