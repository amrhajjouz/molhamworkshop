function userWorkExperiencesControllerInit($apiRequest, $page, $datalist) {
    console.log($datalist('members/user_work_experiences/' + $page.routeParams.id, true).load())
    return $datalist('members/user_work_experiences/' + $page.routeParams.id, true).load();
}

function userWorkExperiencesController($scope, $apiRequest, $init) {
    $scope.userWorkExperiences = $init;
}