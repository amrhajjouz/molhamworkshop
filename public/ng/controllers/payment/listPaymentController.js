async function listPaymentControllerInit($page, $datalist) {
    return {
        payments: await $datalist(`payments`, true).load()
    }
}

function listPaymentController($scope, $init, $apiRequest) {
    $scope.payments = $init.payments;
    $scope.payment = {};
    $scope.showReversalModal = function (paymentId) {
        $scope.payment.paymentId = paymentId;
        $('#payment-confirmation').modal('show');
    }

    $scope.reverse = function () {
        $apiRequest.config({
            method: 'POST',
            url: `payments/${$scope.payment.paymentId}/reverse`,
            data: $scope.payment
        }, function (response, data) {
            $scope.payments.load();
            $('#payment-confirmation').modal('hide');
        }).send();
    }

    $scope.refund = function (paymentId) {
        $apiRequest.config({
            method: 'POST',
            url: `payments/${paymentId}/reverse`,
        }, function (response, data) {
        }).send();
    }
}
