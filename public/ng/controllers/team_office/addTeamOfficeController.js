function addTeamOfficeControllerInit () {
    return [];
}

function addTeamOfficeController ($scope, $apiRequest, $page) {

    $scope.teamOffice = {};

    $scope.createTeamOffice = $apiRequest.config({
        method: 'POST',
        url: 'team_offices',
        data: $scope.teamOffice,
    }, function (response, data) {
        $page.navigate('team_offices.overview', {id: data.id});
    });
}
