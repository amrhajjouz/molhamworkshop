function addUserFamilyMemberControllerInit () {
    return [];
}

function addUserFamilyMemberController ($scope, $apiRequest, $page) {

    $scope.userFamilyMember = {};

    $scope.createUserFamilyMember = $apiRequest.config({
        method: 'POST',
        url: 'user_family_members',
        data: $scope.userFamilyMember,
    }, function (response, data) {
        $page.navigate('user_family_members.overview', {id: data.id});
    });
}
