function listWarehousesControllerInit ($page, $datalist) {
    return $datalist('warehouses', true).load();
}

function listWarehousesController ($scope, $init) {
   $scope.warehouses = $init;
}
