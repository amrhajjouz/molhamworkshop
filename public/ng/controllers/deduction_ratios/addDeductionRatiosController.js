function addDeductionRatiosController($scope, $page, $apiRequest) {
    $scope.deductionRatios = {targets: []};

    $scope.addNewPurpose = function () {
        $scope.deductionRatios.targets.push({ratio: 1, account_id: null})
    }

    $scope.deletePurpose = function (x) {
        const index = $scope.deductionRatios.targets.indexOf(x);
        $scope.deductionRatios.targets.splice(index, 1);
    }

    $scope.createDeductionRatios = $apiRequest.config({
        method: 'POST',
        url: `deduction_ratios`,
        data: $scope.deductionRatios,
    }, function (response, data) {
        $page.navigate('deduction-ratios');
    })
}
