function listBoardControllerInit ($page, $datalist) {
    return $datalist('boards', true).load();
}

function listBoardController ($scope, $init) {
   $scope.boards = $init;
}
