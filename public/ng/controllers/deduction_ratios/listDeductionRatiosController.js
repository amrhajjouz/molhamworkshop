function listDeductionRatiosControllerInit($apiRequest) {
    return $apiRequest.config('deduction_ratios').getData();
}

function listDeductionRatiosController($scope, $init, $apiRequest) {
    $scope.deductionRatios = $init;
    $scope.cancelDeductionRatios = function (id) {
        if (!confirm("are you sure you want to cancel this ratio")) {
            return;
        }
        $apiRequest.config({
            method: 'DELETE',
            url: `deduction_ratios/${id}`,
        }, async function () {
            $scope.deductionRatios = await $apiRequest.config("deduction_ratios").getData()
            $scope.$apply()
        }).send()
    }
}
