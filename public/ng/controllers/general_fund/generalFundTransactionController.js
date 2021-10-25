async function generalFundTransactionControllerInit($page, $datalist) {
    return {
        transactions: await $datalist(`transactions/general_fund`, true).load()
    }
}

function generalFundTransactionController($scope, $init, $apiRequest) {
    $scope.transactions = $init.transactions;
    $scope.deleteTransaction = function (transaction) {
        $apiRequest.config({
            method: 'DELETE',
            url: `payment/transactions/${transaction.id}`,
        }, function (response, data) {
            $scope.transactions.load();
        }).send()
    };
}
