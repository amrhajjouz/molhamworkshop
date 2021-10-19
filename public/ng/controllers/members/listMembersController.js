function listMembersControllerInit($datalist) {
    return $datalist("members", true).load();
}

function listMembersController($scope, $apiRequest, $init, $page) {
    $scope.members = $init;

    //Delete
    $scope.deleteMemberController = function (id) {
        var result = confirm("هل تريد الحذف؟");
        if (result) {
            $apiRequest.config( {
                method: "DELETE",
                url: "members/" + id,
            }, function (response, data) {
                $page.reload();
            }).send();
        }

    }
}