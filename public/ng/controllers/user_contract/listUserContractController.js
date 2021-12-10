function listUserContractControllerInit ($page, $datalist) {
    return $datalist('user_contracts', true).load();
}

function listUserContractController ($scope, $init) {
   $scope.userContracts = $init;
}
