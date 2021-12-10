function addUserSkillControllerInit () {
    return [];
}

function addUserSkillController ($scope, $apiRequest, $page) {

    $scope.userSkill = {};

    $scope.createUserSkill = $apiRequest.config({
        method: 'POST',
        url: 'user_skills',
        data: $scope.userSkill,
    }, function (response, data) {
        $page.navigate('user_skills.overview', {id: data.id});
    });
}
