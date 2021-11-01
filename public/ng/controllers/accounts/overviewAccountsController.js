function  overviewAccountsControllerInit ($page, $apiRequest) {
    return $apiRequest.config('accounts/' + $page.routeParams.id).getData();
}

function overviewAccountsController ($scope, $init) {
    $scope.account = $init;
}
