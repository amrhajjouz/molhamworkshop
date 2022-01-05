function infoMembersControllerInit($apiRequest, $page) {
    console.log($apiRequest.config("members/info/" + $page.routeParams.id).getData())
    return $apiRequest.config("members/info/" + $page.routeParams.id).getData();
}

function infoMembersController($scope, $apiRequest, $init, $page) {
    $scope.userInfo = $init;
}