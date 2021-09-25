function editWarehouseControllerInit ($page, $apiRequest) {
    return $apiRequest.config('warehouses/' + $page.routeParams.id).getData();
}

function editWarehouseController ($scope, $apiRequest, $init,$page) {
   $scope.warehouse = $init;
      $scope.updateWarehouse = $apiRequest.config({
          method : 'PUT',
          url : 'warehouses',
          data : $scope.warehouse,
      }, function (response, data) {
        $page.navigate('warehouses.overview', {id: data.id});
      });
}
