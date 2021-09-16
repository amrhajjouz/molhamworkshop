async function addCurrencyControllerInit($apiRequest) {

}

function addCurrencyController ($scope, $apiRequest, $page) {

    $scope.currency = {};

    $scope.createCurrency = $apiRequest.config({
        method: 'POST',
        url: 'currencies',
        data: $scope.currency,
    }, function (response, data) {
        $page.navigate('currencies.overview', {id: data.id});
    });
}
