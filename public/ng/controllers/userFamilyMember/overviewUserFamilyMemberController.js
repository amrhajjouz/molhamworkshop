function overviewUserFamilyMemberControllerInit ($apiRequest, $page) {
    return $apiRequest.config('user_family_members/' + $page.routeParams.id).getData();
}

function overviewUserFamilyMemberController ($scope, $init) {
    $scope.userFamilyMember = $init;
}
