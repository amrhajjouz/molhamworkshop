function editLoanRequestControllerInit ($page, $apiRequest) {
    return $apiRequest.config('loan_requests/' + $page.routeParams.id).getData();
}

function editLoanRequestController ($scope, $apiRequest, $init) {

    $scope.loanRequest = $init;

    console.log($scope.loanRequest);
    $scope.updateLoanRequest = $apiRequest.config({
      method : 'PUT',
      url : 'loan_requests',
      data : $scope.loanRequest,
    }, function (response, data) {

    });


}
