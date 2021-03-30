function listPlacesControllerInit($datalist) {
  return $datalist("places", true).load();
}

function listPlacesController($scope, $init) {
    
    $scope.places = $init;
}