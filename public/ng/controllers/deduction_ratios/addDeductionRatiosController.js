function addDeductionRatiosController($scope, $page, $apiRequest) {
    $scope.deductionRatios = {};

    $scope.createDeductionRatios = $apiRequest.config({
        method: 'POST',
        url: `deduction_ratios`,
        data: $scope.deductionRatios,
    }, function (response, data) {
        $page.navigate('deduction-ratios');
    })
}
