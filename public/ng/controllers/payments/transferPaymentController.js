async function transferPaymentControllerInit($datalist) {

}

function transferPaymentController($scope, $apiRequest, $page, $init) {
$scope.transfer = {};
    $scope.transferTransaction = $apiRequest.config({
        method: 'POST',
        url: 'payments/transfer',
        data: $scope.transfer,
    }, function (response, data) {
      //todo check with amr what is after ?
    });
}
