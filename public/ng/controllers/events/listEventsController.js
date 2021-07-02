function listEventsControllerInit($datalist, $location) {
    return $datalist('events', true).load();
}
function listEventsController($scope, $init, $datalist) {
    $scope.events = $init;
}
