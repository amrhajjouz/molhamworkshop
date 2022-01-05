function userSkillsControllerInit($apiRequest, $page, $datalist) {
    console.log($datalist('members/user_skills/' + $page.routeParams.id, true).load())
    return $datalist('members/user_skills/' + $page.routeParams.id, true).load();
}

function userSkillsController($scope, $apiRequest, $init) {
    $scope.userSkills = $init;
}