function listConstantsControllerInit($datalist) {
  return $datalist("constants", true).load();
}

function listConstantsController($scope, $init) {
    $scope.constants = $init;
}