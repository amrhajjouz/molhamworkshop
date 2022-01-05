function userFamilyMembersControllerInit($apiRequest, $page, $datalist) {
    console.log($datalist('members/user_family_member/' + $page.routeParams.id, true).load())
    return $datalist('members/user_family_member/' + $page.routeParams.id, true).load();
}

function userFamilyMembersController($scope, $apiRequest, $init, $page) {
    $scope.userFamilyMembers = $init;
}