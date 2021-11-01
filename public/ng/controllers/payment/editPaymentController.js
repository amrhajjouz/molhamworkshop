function editPaymentControllerInit ($page, $apiRequest) {
    return $apiRequest.config('payments/' + $page.routeParams.id).getData();
}

function editPaymentController ($scope, $apiRequest, $init) {
   $scope.payment = $init;
      $scope.updatePayment = $apiRequest.config({
          method : 'PUT',
          url : 'payments',
          data : $scope.payment,
      }, function (response, data) {

      });
}
