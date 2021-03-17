function listDonorsControllerInit ($apiRequest) {
    return $apiRequest.config('donors').getData();
}
function listDonorsController ($scope, $init) {
    $scope.donors = $init;
}
