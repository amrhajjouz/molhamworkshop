function listAdvancePaymentRequestControllerInit ($page, $datalist) {
    return $datalist('advance_payment_requests', true).load();
}

function listAdvancePaymentRequestController ($scope, $init) {
   $scope.advancePaymentRequests = $init;
}
