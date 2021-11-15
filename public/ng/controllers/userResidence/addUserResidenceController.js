function addUserResidenceControllerInit () {
    return [];
}

function addUserResidenceController ($scope, $apiRequest, $page) {

    $scope.userResidence = {};

    $scope.createUserResidence = $apiRequest.config({
        method: 'POST',
        url: 'user_residences',
        data: $scope.userResidence,
    }, function (response, data) {
        $page.navigate('user-residences.overview', {id: data.id});
    });
}
