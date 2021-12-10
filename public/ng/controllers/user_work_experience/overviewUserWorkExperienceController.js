function overviewUserWorkExperienceControllerInit ($apiRequest, $page) {
    return $apiRequest.config('user_work_experiences/' + $page.routeParams.id).getData();
}

function overviewUserWorkExperienceController ($scope, $init) {
    $scope.userWorkExperience = $init;
}
