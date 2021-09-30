async function listPaymentControllerInit ($page, $datalist) {
    return {
        payments: await $datalist(`payments`, true).load()
    }}

function listPaymentController ($scope, $init) {
    $scope.payments = $init.payments;
}
