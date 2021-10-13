function overViewBoardControllerInit ($apiRequest, $page) {
    return $apiRequest.config('boards/' + $page.routeParams.id).getData();
}

function overviewBoardController ($scope, $init) {
    $scope.board = $init;
}
