function listReceiverControllerInit ($datalist) {
    return $datalist('receivers', true).load();
}
function listReceiverController ($scope, $init) {
    $scope.receivers = $init;
}
