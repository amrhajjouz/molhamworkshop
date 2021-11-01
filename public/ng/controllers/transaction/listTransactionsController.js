async function listTransactionsControllerInit($datalist,$page) {
    return {
        transactions: await $datalist("transactions/"+$page.routeParams.account_id, true).load()
    };
}

function listTransactionsController($scope, $init) {
    $scope.transactions = $init.transactions;
}
