async function listPayoutVoucherControllerInit($datalist) {
    return {
        vouchers: await $datalist('payouts/vouchers/list', true).load()
    }
}

 function listPayoutVoucherController($scope, $init, $apiRequest) {
    $scope.vouchers = $init.vouchers;

    $scope.setSpentAt = function (voucher) {
        $scope.voucher = {
            id: voucher.id,
            spent_at: true
        }
        $scope.updateStatus();
    }

    $scope.setDeliveredAt = function (voucher) {
        $scope.voucher = {
            id: voucher.id,
            delivered_at: true
        }
        $scope.updateStatus();
    }

    $scope.updateStatus = function () {
        $apiRequest.config({
            method: 'PUT',
            url: `payouts/vouchers/${$scope.voucher.id}/update-status`,
            data: $scope.voucher,
        }, function () {
            $scope.vouchers.load()
        }).send();
    }
}
