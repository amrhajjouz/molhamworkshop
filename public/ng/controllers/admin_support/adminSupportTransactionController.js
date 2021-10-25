async function adminSupportTransactionControllerInit($page, $datalist) {
    return {
        transactions: await $datalist(`transactions/administrative_support`, true).load()
    }
}

function adminSupportTransactionController($scope,$apiRequest, $init) {
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
