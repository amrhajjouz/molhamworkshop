function listUserWorkExperienceControllerInit ($page, $datalist) {
    return $datalist('user_work_experiences', true).load();
}

function listUserWorkExperienceController ($scope, $init) {
   $scope.userWorkExperiences = $init;
}
