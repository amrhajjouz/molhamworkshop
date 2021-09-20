function listAccountsControllerInit($apiRequest) {
    return $apiRequest.config("accounts").getData();
}

function listAccountsController($scope, $init,$apiRequest) {
    $scope.accounts = $init;

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
