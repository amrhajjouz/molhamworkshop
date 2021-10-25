async function spentPaymentListControllerInit($datalist) {
    return {
        payments: await $datalist(`payments/spent`, true).load()
    }
}

function spentPaymentListController($scope, $init, $apiRequest) {
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
