function overviewTeamOfficeControllerInit ($apiRequest, $page) {
    return $apiRequest.config('team_offices/' + $page.routeParams.id).getData();
}

function overviewTeamOfficeController ($scope, $init) {
    $scope.teamOffice = $init;
}
