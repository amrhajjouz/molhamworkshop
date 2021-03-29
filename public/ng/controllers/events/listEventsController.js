function listEventsControllerInit($apiRequest) {
  return $apiRequest.config("events").getData();
}

function listEventsController($scope, $init) {
  $scope.events = $init;
}
