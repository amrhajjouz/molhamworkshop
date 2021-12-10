function overviewUserSkillControllerInit ($apiRequest, $page) {
    return $apiRequest.config('user_skills/' + $page.routeParams.id).getData();
}

function overviewUserSkillController ($scope, $init) {
    $scope.userSkill = $init;
}
