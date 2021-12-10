/*function contractMembersControllerInit($datalist) {
    //console.log($datalist)
    return $datalist("members", true).load();
}*/

function contractMembersControllerInit ($apiRequest, $page, $datalist) {
    return $datalist('members/contracts/' + $page.routeParams.id, true).load();
}

function contractMembersController($scope, $apiRequest, $init, $page) {
    $scope.userContracts = $init;
}