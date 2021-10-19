async function addMemberControllerInit($apiRequest) {

}

function addMemberController($scope, $location, $apiRequest, $page, $init) {

    $scope.member = {};
    $scope.parentMembers = [];

    $scope.createMember = $apiRequest.config({
        method: "POST",
        url: "members",
        data: $scope.member
    }, function (response, data) {
        $page.navigate("members.overview", {
            id: data.id
        });
    });
}