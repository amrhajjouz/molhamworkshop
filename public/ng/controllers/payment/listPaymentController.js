function listPaymentControllerInit ($page, $datalist) {
    return $datalist('payments', true).load();
}

function listPaymentController ($scope, $init) {
   $scope.payments = $init;
}
