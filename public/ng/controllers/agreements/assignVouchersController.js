async function assignVouchersControllerInit($datalist, $page, $apiRequest) {
    return {
        vouchers: await $datalist('agreements/' + $page.routeParams.id + '/vouchers', true).load(),
        agreement: await $apiRequest.config('agreements/' + $page.routeParams.id + '/summary').getData()
    }
}

function assignVouchersController($scope, $page, $init, $apiRequest) {
    $scope.vouchers = $init.vouchers;
    $scope.agreement = $init.agreement;
    $scope.agreementId = $page.routeParams.id;
    $scope.voucher = {};
    $scope.totalVoucherAmount = calculateTotalVouchers($scope.agreement.admin_costs_percentage);

    $scope.AssignVouchers = function () {
        if (!confirm('هل أنت متأكد من العملية؟')) {
            return;
        }
        $apiRequest.config({
            method: 'PUT',
            url: `agreements/${$page.routeParams.id}/assign/${$scope.voucher.id}`,
        }, function () {
            $scope.refreshData();
        }).send();
    }

    $scope.refreshData = async function () {
        $scope.voucher = {};
        await $scope.vouchers.load();
        $scope.totalVoucherAmount = calculateTotalVouchers($scope.agreement.admin_costs_percentage);
        $scope.$apply(); //todo check with amr;
    }

    $scope.removeFromVoucher = function (voucher) {
        if (!confirm('هل أنت متأكد من العملية؟')) {
            return;
        }
        $apiRequest.config({
            method: 'PUT',
            url: `agreements/${$page.routeParams.id}/assign/${$scope.voucher.id}`,
            url: `agreements/${$page.routeParams.id}/invoke/${voucher.id}`,
        }, function () {
            $scope.refreshData()
        }).send();
    }

    function calculateTotalVouchers(percentage) {
        const amount = $scope.vouchers.data.reduce((a, n) => a + Number(n.amount), 0);
        return amount + amount * Number(percentage) / 100;
    }
}
