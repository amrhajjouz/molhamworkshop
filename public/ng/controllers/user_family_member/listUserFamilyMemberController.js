function listUserFamilyMemberControllerInit ($page, $datalist) {
    return $datalist('user_family_members', true).load();
}

function listUserFamilyMemberController ($scope, $apiRequest, $init, $page) {
   $scope.userFamilyMembers = $init;

    //Delete
    $scope.deleteUserFamilyMemberController = function (id) {
        var result = confirm("هل تريد الحذف؟");
        if (result) {
            $apiRequest.config( {
                method: "DELETE",
                url: "user_family_members/" + id,
            }, function (response, data) {
                $page.reload();
            }).send();
        }

    }
}
