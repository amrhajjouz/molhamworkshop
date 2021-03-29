function listDonorsControllerInit ($datalist, $location) {
    return $datalist('donors', true).load();
}

function listDonorsController ($scope, $init, $datalist) {
    
    $scope.donors = $init;
    
}
