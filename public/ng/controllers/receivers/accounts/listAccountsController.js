async function listAccountsControllerInit($page, $apiRequest) {
    return {
        currencies: await $apiRequest.config('currencies').getData(),
        accountsTypes: await $apiRequest.config('accounts/types').getData(),
        accounts: await $apiRequest.config(`receivers/${$page.routeParams.id}/accounts`).getData()
    }
}

function listAccountsController($scope, $page, $apiRequest, $init) {
    $scope.accounts = $init.accounts;
    $scope.accountsTypes = $init.accountsTypes;
    $scope.currencies = $init.currencies;
    $scope.selectedAccount = {};
    $scope.transaction = {};
    $scope.createUpdateAccount = $apiRequest.config({
        method: 'POST',
        url: `receivers/${$page.routeParams.id}/accounts`,
        data: $scope.account,
    }, function (response, data) {
        if ($scope.currentAccountModalAction == 'edit') {
            $scope.accounts[$scope.accounts.findIndex(a => a.id === data.id)] = data;
        } else {
            $scope.accounts.push(data);
        }
        $('#account-modal').modal('hide');
    });

    $scope.currentAccountModalAction = 'add';

    $scope.showAccountModal = function (action, data = {}) {
        $scope.currentAccountModalAction = action;
        $scope.createUpdateAccount.config.method = (action == 'add') ? 'POST' : 'PUT';
        $scope.account = angular.copy(data);
        $('#account-modal').modal('show');
    }
    $scope.showTransactionModel = function(data,type){
        $scope.selectedAccount = angular.copy(data);
        $scope.transaction = {
            from:data.id,
            type : type,
        };
        $('#transaction-modal').modal('show');
    }
    $scope.createTransaction = $apiRequest.config({
        method: 'POST',
        url: `receivers/${$page.routeParams.id}/transactions`,
        data: $scope.transaction,
    }, function () {
         $('#transaction-modal').modal('hide');
        $page.navigate('receivers.transactions', {id: $page.routeParams.id});
    });
}
