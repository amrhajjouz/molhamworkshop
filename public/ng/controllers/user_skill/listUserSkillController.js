function listUserSkillControllerInit ($page, $datalist) {
    return $datalist('user_skills', true).load();
}

function listUserSkillController ($scope, $init) {
   $scope.userSkills = $init;
}
