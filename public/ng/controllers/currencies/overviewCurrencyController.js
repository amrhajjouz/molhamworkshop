function overviewCurrencyControllerInit ($apiRequest, $page) {
    return $apiRequest.config('currencies/' + $page.routeParams.id).getData();
}

function overviewCurrencyController ($scope, $init) {
    $scope.currency = $init;
}
