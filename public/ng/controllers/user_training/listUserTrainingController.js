function listUserTrainingControllerInit ($page, $datalist) {
    return $datalist('user_trainings', true).load();
}

function listUserTrainingController ($scope, $init) {
   $scope.userTrainings = $init;
}
