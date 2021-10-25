async function addAgreementControllerInit($apiRequest) {
    return {
        currencies: await $apiRequest.config('currencies').getData(),
    }
}
function addAgreementController ($scope, $apiRequest, $init) {

    $scope.agreement = {};
    $scope.currencies = $init.currencies;

    $scope.createAgreement = $apiRequest.config({
        method: 'POST',
        url: 'agreements',
        data: $scope.agreement,
    }, function (response, data) {
       // $page.navigate('donors.overview', {id: data.id});
    });

}
