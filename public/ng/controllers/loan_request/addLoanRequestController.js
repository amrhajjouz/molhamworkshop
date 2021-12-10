function addLoanRequestControllerInit () {
    return [];
}

function addLoanRequestController ($scope, $apiRequest, $page) {

    $scope.loanRequest = {};

    $scope.createLoanRequest = $apiRequest.config({
        method: 'POST',
        url: 'loan_requests',
        data: $scope.loanRequest,
    }, function (response, data) {
        $page.navigate('loan-requests.overview', {id: data.id});
    });
}
