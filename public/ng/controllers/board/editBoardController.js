function editBoardControllerInit ($page, $apiRequest) {
    return $apiRequest.config('boards/' + $page.routeParams.id).getData();
}

function editBoardController ($scope, $apiRequest, $init) {
   $scope.board = $init;
      $scope.updateBoard = $apiRequest.config({
          method : 'PUT',
          url : 'boards',
          data : $scope.board,
      }, function (response, data) {

      });
}
