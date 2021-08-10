function listApiErrorsControllerInit($datalist, $location) {
    return $datalist('api_errors', true).load();
}
function listApiErrorsController($scope, $init, $datalist) {
    $scope.apiErrors = $init;

}
