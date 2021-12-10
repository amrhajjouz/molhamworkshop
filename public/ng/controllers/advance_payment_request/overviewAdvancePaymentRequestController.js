function overviewAdvancePaymentRequestControllerInit ($apiRequest, $page) {
    return $apiRequest.config('advance_payment_requests/' + $page.routeParams.id).getData();
}

function overviewAdvancePaymentRequestController ($scope, $init) {
    $scope.advancePaymentRequest = $init;
}
