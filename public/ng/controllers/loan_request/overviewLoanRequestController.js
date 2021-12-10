function overviewLoanRequestControllerInit ($apiRequest, $page) {
    return $apiRequest.config('loan_requests/' + $page.routeParams.id).getData();
}

function overviewLoanRequestController ($scope, $page, $apiRequest, $init) {

    $scope.loanRequest = $init;

    $scope.updateLoanRequest = $apiRequest.config({
        method : 'POST',
        url : 'loan_requests',
        data : $scope.loanRequest,
    }, function (response, data) {

    });
}
