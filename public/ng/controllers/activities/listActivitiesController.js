function listActivitiesControllerInit($datalist, $location) {
    return $datalist('activities', true).load();
}
function listActivitiesController($scope, $init, $datalist) {
    $scope.activities = $init;
}
