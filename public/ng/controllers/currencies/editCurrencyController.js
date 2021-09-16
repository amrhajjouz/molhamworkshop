function editCurrencyControllerInit ($page, $apiRequest) {
    return $apiRequest.config('currencies/' + $page.routeParams.id).getData();
}

function editCurrencyController ($scope, $apiRequest,$page, $init) {
   $scope.currency = $init;
      $scope.updateCurrency = $apiRequest.config({
          method : 'PUT',
          url : 'currencies',
          data : $scope.currency,
      }, function (response, data) {
          $page.navigate("currencies.overview", {
                    id: data.id,
          });
      });
      $scope.delete = ''

}
