async function receivedPaymentListControllerInit($datalist) {
    return {
        payments: await $datalist(`payments/received`, true).load()
    }
}

function receivedPaymentListController($scope, $init, $apiRequest) {
    $scope.payments = $init.payments;
    $scope.deletePayment = function (payment) {
        $apiRequest.config({
            method: 'DELETE',
            url: `payment/${payment.id}`,
        }, function (response, data) {
            $scope.payments.load();
        }).send()
    };
}
