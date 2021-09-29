function listLoanRequestControllerInit ($page, $datalist) {
    return $datalist('loan_requests', true).load();
}

function listLoanRequestController ($scope, $apiRequest, $init, $page) {

    $scope.loanRequests = $init;

    //Delete Human
    $scope.deleteLoanRequestController = function (id) {
        var result = confirm("هل تريد الحذف؟");
        if (result) {
            $apiRequest.config( {
                method: "DELETE",
                url: "loan_requests/" + id,
            }, function (response, data) {
                $page.reload();
            }).send();
        }

    }
}
