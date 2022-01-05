function userTrainingsControllerInit($apiRequest, $page, $datalist) {
    return $datalist('members/user_trainings/' + $page.routeParams.id, true).load();
}

function userTrainingsController($scope, $apiRequest, $init) {
    $scope.userTrainings = $init;
}