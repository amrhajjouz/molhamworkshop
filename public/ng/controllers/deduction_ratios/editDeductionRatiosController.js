function  editDeductionRatiosControllerInit ($page, $apiRequest) {
    return $apiRequest.config(`deduction_ratios/${$page.routeParams.id}`).getData();
}

function editDeductionRatiosController ($scope, $page, $apiRequest, $init) {
    $scope.deductionRatios = $init;

    $scope.updateDeductionRatios = $apiRequest.config({
        method: 'PUT',
        url: `deduction_ratios`,
        data: $scope.deductionRatios,
    }, function (response, data) {

    })
}
