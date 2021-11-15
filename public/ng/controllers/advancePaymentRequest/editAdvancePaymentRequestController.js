function editAdvancePaymentRequestControllerInit ($page, $apiRequest) {
    return $apiRequest.config('advance_payment_requests/' + $page.routeParams.id).getData();
}

function editAdvancePaymentRequestController ($scope, $apiRequest, $init) {
   $scope.advancePaymentRequest = $init;
      $scope.updateAdvancePaymentRequest = $apiRequest.config({
          method : 'PUT',
          url : 'advance_payment_requests',
          data : $scope.advancePaymentRequest,
      }, function (response, data) {

      });
}
