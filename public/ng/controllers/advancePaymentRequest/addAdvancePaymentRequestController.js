function addAdvancePaymentRequestControllerInit () {
    return [];
}

function addAdvancePaymentRequestController ($scope, $apiRequest, $page) {

    $scope.advancePaymentRequest = {};

    $scope.createAdvancePaymentRequest = $apiRequest.config({
        method: 'POST',
        url: 'advance_payment_requests',
        data: $scope.advancePaymentRequest,
    }, function (response, data) {
        $page.navigate('advance-payment-requests.overview', {id: data.id});
    });
}
