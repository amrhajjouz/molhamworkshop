function listTeamOfficeControllerInit ($page, $datalist) {
    return $datalist('team_offices', true).load();
}

function listTeamOfficeController ($scope, $init) {
   $scope.teamOffices = $init;
}
