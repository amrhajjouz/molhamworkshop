function listPagesControllerInit($datalist) {
  return $datalist("pages", true).load();
}

function listPagesController($scope, $init) {
  $scope.pages = $init;
}
