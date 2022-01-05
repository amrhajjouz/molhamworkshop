function listLeaveControllerInit ($page, $datalist) {
    return $datalist('leaves', true).load();
}

function listLeaveController ($scope, $apiRequest, $init, $page) {
   $scope.leaves = $init;

    //Delete
    $scope.deleteMemberLeaveController = function (id) {
        var result = confirm("هل تريد الحذف؟");
        if (result) {
            $apiRequest.config({
                method: "DELETE",
                url: "leaves/" + id,
            }, function (response, data) {
                $page.reload();
            }).send();
        }

    }
}
