function overviewBoardControllerInit($apiRequest, $page) {
    return $apiRequest.config("boards/" + $page.routeParams.id).getData();
}

function overviewBoardController($scope, $init, $apiRequest, $page) {
    $scope.board = $init;
}
