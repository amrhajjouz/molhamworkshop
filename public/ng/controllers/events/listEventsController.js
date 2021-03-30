function listEventsControllerInit($datalist) {
  return $datalist("events", true).load();
}

function listEventsController($scope, $init) {
  $scope.events = $init;
}
