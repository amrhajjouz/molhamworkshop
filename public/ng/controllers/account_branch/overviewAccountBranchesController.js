function  overviewAccountBranchesControllerInit ($page, $apiRequest) {
    return $apiRequest.config('account_branches/' + $page.routeParams.id).getData();
}

function overviewAccountBranchesController ($scope, $init) {
    $scope.accountBranches = $init;
}
