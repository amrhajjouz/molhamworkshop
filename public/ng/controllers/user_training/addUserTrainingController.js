function addUserTrainingControllerInit () {
    return [];
}

function addUserTrainingController ($scope, $apiRequest, $page) {

    $scope.userTraining = {};

    $scope.createUserTraining = $apiRequest.config({
        method: 'POST',
        url: 'user_trainings',
        data: $scope.userTraining,
    }, function (response, data) {
        $page.navigate('user_trainings.overview', {id: data.id});
    });
}
