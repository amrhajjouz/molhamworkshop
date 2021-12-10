function profileContractControllerInit ($datalist) {
    return $datalist('profile/contracts', true).load();
}

function profileContractController ($scope, $init) {
    $scope.userContracts = $init;
}