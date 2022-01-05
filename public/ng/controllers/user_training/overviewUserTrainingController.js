function overviewUserTrainingControllerInit ($apiRequest, $page) {
    return $apiRequest.config('user_trainings/' + $page.routeParams.id).getData();
}

function overviewUserTrainingController ($scope, $init) {
    $scope.userTraining = $init;
}
