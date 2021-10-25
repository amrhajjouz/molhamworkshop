async function addPayoutRequestControllerInit($page, $apiRequest) {
    return {
        countries: await $apiRequest.config('countries').getData(),
        currencies: await $apiRequest.config('currencies').getData(),
    }
}

function addPayoutRequestController($scope,$page, $init, $apiRequest) {
    $scope.payout = {};
    $scope.countries = $init.countries;
    $scope.currencies = $init.currencies;
    $scope.createPayout = $apiRequest.config({
        method: 'POST',
        url: 'payouts/requests',
        data: $scope.payout,
    }, function () {
        $page.navigate('payouts.requests.list');
    });
}
