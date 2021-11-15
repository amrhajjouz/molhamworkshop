function listTravelRequestControllerInit ($page, $datalist) {
    return $datalist('travel_requests', true).load();
}

function listTravelRequestController ($scope, $apiRequest, $init, $page) {

    $scope.travelRequests = $init;

    //Delete
    $scope.deleteTravelRequestController = function (id) {
        var result = confirm("هل تريد الحذف؟");
        if (result) {
            $apiRequest.config( {
                method: "DELETE",
                url: "travel_requests/" + id,
            }, function (response, data) {
                $page.reload();
            }).send();
        }

    }
}
