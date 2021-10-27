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

    //memberAction
    let member_action
    /*$scope.memberAction = function (career_level, office, section) {
        if (career_level === 'ceo' || office === 'syria' || section === 'finance') {
            member_action = ['administrative', 'turkey', 'hr'];
        } else if (career_level === 'ceo' || office === 'turkey') {
            member_action = ['department_assistant', 'syria'];
        }
        $scope.member.job_title = member_action[0];
        $scope.member.office = member_action[1];
    }*/
}
