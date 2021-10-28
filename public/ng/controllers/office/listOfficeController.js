function listOfficeControllerInit ($page, $datalist) {
    return $datalist('offices', true).load();
}

function listOfficeController ($scope, $init) {
   $scope.offices = $init;
}
