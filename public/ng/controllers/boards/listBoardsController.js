function listBoardsControllerInit($page, $datalist) {
    return $datalist("boards", true).load();
}

function listBoardsController($scope, $init) {
    $scope.boards = $init;
}
