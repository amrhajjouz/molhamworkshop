function addBoardControllerInit () {
    return [];
}

function addBoardController ($scope, $apiRequest, $page) {

    $scope.board = {};

    $scope.createBoard = $apiRequest.config({
        method: 'POST',
        url: 'boards',
        data: $scope.board,
    }, function (response, data) {
        $page.navigate('boards.overview', {id: data.id});
    });
}
