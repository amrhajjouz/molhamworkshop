function overViewPaymentControllerInit ($apiRequest, $page) {
    return $apiRequest.config('payments/' + $page.routeParams.id).getData();
}

function overviewPaymentController ($scope, $init) {
    $scope.payment = $init;
}
