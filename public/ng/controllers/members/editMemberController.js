async function editMemberControllerInit($http, $page, $apiRequest) {
    return await $apiRequest.config("members/" + $page.routeParams.id).getData();
}

function editMemberController($scope, $page, $apiRequest, $init) {

    $scope.member = $init;

    $scope.updateMember = $apiRequest.config({
        method: "PUT",
        url: "members",
        data: $scope.member,
    }, function (response, data) {

    });
}
