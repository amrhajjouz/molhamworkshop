function overviewWarehouseControllerInit ($apiRequest, $page) {
    return $apiRequest.config('warehouses/' + $page.routeParams.id).getData();
}

function overviewWarehouseController ($scope, $init) {
    $scope.warehouse = $init;
}
