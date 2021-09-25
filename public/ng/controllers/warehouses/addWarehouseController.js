function addWarehouseControllerInit () {
    return [];
}

function addWarehouseController ($scope, $apiRequest, $page) {

    $scope.warehouse = {};

    $scope.createWarehouse = $apiRequest.config({
        method: 'POST',
        url: 'warehouses',
        data: $scope.warehouse,
    }, function (response, data) {
        $page.navigate('warehouses.overview', {id: data.id});
    });
}
