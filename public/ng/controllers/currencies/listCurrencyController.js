function listCurrencyControllerInit ($page, $datalist) {
    return $datalist('currencies', true).load();
}

function listCurrencyController ($scope, $init,$apiRequest, $page) {
   $scope.currencies = $init;
   $scope.removeCurrency = (id)=>{
          $apiRequest.config({
                    method: 'DELETE',
                    url: 'currencies/'+ id,
                }, function (response, data) {
                    $page.reload();
                }).send();
      }

}
