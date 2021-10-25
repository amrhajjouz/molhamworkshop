async function listTransactionsControllerInit($page, $datalist) {
    return {
        transactions: await $datalist(`receivers/${$page.routeParams.id}/transactions`, true).load()
    }
}

function listTransactionsController($scope, $page, $apiRequest, $init) {
    $scope.transactions = $init.transactions;
    $scope.popoverInit = function () {
        $('[data-toggle="popover"]').popover();
    };

    $scope.deleteTransaction = function (transaction) {
        $apiRequest.config({
            method: 'DELETE',
            url: `receivers/${$page.routeParams.id}/transactions/${transaction.id}`,
        }, function (response, data) {
            $scope.transactions.load();
        }).send()
    };
}
