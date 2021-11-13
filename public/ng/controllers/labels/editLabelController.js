function editLabelControllerInit ($page, $apiRequest) {
    return $apiRequest.config('labels/' + $page.routeParams.id).getData();
}

function editLabelController ($scope, $apiRequest, $init) {
   $scope.label = $init;
      $scope.updateLabel = $apiRequest.config({
          method : 'PUT',
          url : 'labels',
          data : $scope.label,
      }, function (response, data) {

      });
}
