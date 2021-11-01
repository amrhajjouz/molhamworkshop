async function listAccountBranchesControllerInit($apiRequest) {
    return {
        accountBranches: await $apiRequest.config("account_branches").getData(),
        currencies: await $apiRequest.config('currencies').getData(),
        countries: await $apiRequest.config('countries').getData(),
    }
}

function listAccountBranchesController($scope, $page, $init, $apiRequest) {
    $scope.accountBranches = $init.accountBranches;
    $scope.currencies = $init.currencies;
    $scope.countries = $init.countries;
    $scope.selectedMainAccount = {is_child_of_main_title: false};
    $scope.accountBranch = {};
    $scope.account = {};

    $scope.onSelected = function (selections) {
        $scope.nextExpectedSubCode = selections[0].nextExpectedCode;
    }

    $scope.showAccountCreationModal = function (data) {
        $scope.selectedMainAccount = angular.copy(data);
        $scope.account = {account_branch_id: data.id};
        $('#account-create-modal').modal('show');
    }

    $scope.showAccountBranchModal = function (action, data = {}) {
        $scope.accountBranch = {};
        $scope.currentAccountBranchModalAction = action;
        $scope.createUpdateAccountBranch.setByAction(action);
        $scope.accountBranch = angular.copy(data);
        $('#account-branch-modal').modal('show');
    }

    $scope.createAccount = $apiRequest.config({
        method: 'POST',
        url: `accounts`,
        data: $scope.account,
    }, function () {
        $('#account-create-modal').modal('hide');
    });

    $scope.createUpdateAccountBranch = $apiRequest.config({
        url: `account_branches`,
        data: $scope.accountBranch,
    }, async function () {
        $scope.accountBranches = await $apiRequest.config("account_branches").getData()
        $scope.$apply()
        $('#account-branch-modal').modal('hide');
    });
}
