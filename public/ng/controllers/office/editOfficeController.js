function editOfficeControllerInit ($page, $apiRequest) {
    return $apiRequest.config('offices/' + $page.routeParams.id).getData();
}

function editOfficeController ($scope, $apiRequest, $init) {
   $scope.office = $init;
      $scope.updateOffice = $apiRequest.config({
          method : 'PUT',
          url : 'offices',
          data : $scope.office,
      }, function (response, data) {
                $page.navigate('offices');
      });
}
