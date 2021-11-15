function listAdvancePaymentRequestControllerInit ($page, $datalist) {
    return $datalist('advance_payment_requests', true).load();
}

function listAdvancePaymentRequestController ($scope, $apiRequest, $init, $page) {

   $scope.advancePaymentRequests = $init;

    //Delete
    $scope.deleteAdvancePaymentRequestController = function (id) {
        var result = confirm("هل تريد الحذف؟");
        if (result) {
            $apiRequest.config( {
                method: "DELETE",
                url: "advance_payment_requests/" + id,
            }, function (response, data) {
                $page.reload();
            }).send();
        }

    }
}
