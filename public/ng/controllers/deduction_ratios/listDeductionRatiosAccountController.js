function listDeductionRatiosAccountControllerInit($apiRequest,$page) {
    return $apiRequest.config(`deduction_ratios/${$page.routeParams.id}/accounts`).getData();
}

function listDeductionRatiosAccountController($scope,$page, $init, $apiRequest) {
    $scope.deductionRatioAccounts = $init;
    $scope.selectedAccount  = null;

    $scope.addDeductionRatiosAccount = function () {
        $apiRequest.config({
            method: 'POST',
            url: `deduction_ratios/${$page.routeParams.id}/account/${$scope.selectedAccount}`,
        }, function () {
            $scope.selectedAccount  = null;
        }).send()
    }

    $scope.deleteDeductionRatiosAccount = function (id) {
        if (!confirm("are you sure you want to cancel this account")) {
            return;
        }
        $apiRequest.config({
            method: 'DELETE',
            url: `deduction-ratios/${$page.routeParams.id}/account/${id}`,
        }, function () {
        }).send()
    }
}
