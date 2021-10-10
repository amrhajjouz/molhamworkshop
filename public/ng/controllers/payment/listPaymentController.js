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

    $scope.reverse = function (paymentId) {
        //todo: confirm first
        $apiRequest.config({
            method: 'POST',
            url: `payments/${paymentId}/reverse`,
            data: {notes: "test"}
        }, function (response, data) {

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
