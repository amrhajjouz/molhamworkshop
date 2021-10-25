function listPayoutRequestControllerInit($datalist, $location) {
    return $datalist('payouts/requests/list', true).load();
}

function listPayoutRequestController($scope, $init,$apiRequest ,$page ) {

    $scope.payout = $init;
    $scope.voucher = {account_id: null};

    $scope.statusToText = function (text) {
        switch (text) {
            case 'pending':
                return "لم تتم مراجعتها";
            case 'rejected':
                return "تم الرفض";
            case 'approved':
                return "تمت الموافقة";
            default:
                return text;
        }
    }
    $scope.showCreateVoucherModel = function (data) {
        $scope.selectedRequest = angular.copy(data);
        $scope.voucher = {
            payoutRequestId: data.id,
        };
        $('#voucher-modal').modal('show');
    }

    $scope.createVoucher = function () {
        if($scope.voucher.account_id == undefined){
            alert("حقل الحساب مطلوب");
            return;
        }
        $('#voucher-modal').modal('hide');
        $apiRequest.config({
            method: 'POST',
            url: `payouts/requests/${$scope.voucher.payoutRequestId}/voucher`,
            data: $scope.voucher,
        }, function () {
            $page.navigate('payouts.vouchers.list');
        }).send();
    }

    $scope.directToVoucher = function (vocherId) {
       alert("this function should direct to voucher page later, press ok to direct to the list");
        $page.navigate('payouts.vouchers.list');
    }
}
