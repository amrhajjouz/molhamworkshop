async function listAccountsControllerInit($apiRequest) {
    return {
        accounts: await $apiRequest.config("accounts").getData(),
        deduction_ratios: await $apiRequest.config("deduction_ratios").getData()
    };
}

function listAccountsController($scope, $init, $apiRequest) {
    $scope.accounts = $init.accounts;
    $scope.deductionRatios = $init.deduction_ratios;
    $scope.account = {};
    $scope.showAccountModal = function (data) {
        $scope.account = angular.copy(data);
        $('#account-update-modal').modal('show');
    }

    $scope.updateAccount = $apiRequest.config({
        method: 'PUT',
        url: `accounts`,
        data: $scope.account,
    }, async function () {
        $scope.accounts = await $apiRequest.config("accounts").getData()
        $scope.$apply()
        $('#account-update-modal').modal('hide');
    });
}
