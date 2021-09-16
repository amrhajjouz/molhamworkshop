function listCurrencyControllerInit ($page, $datalist) {
    return $datalist('currencies', true).load();
}

function listCurrencyController ($scope, $init,$apiRequest, $page) {
   $scope.currencies = $init;


}
