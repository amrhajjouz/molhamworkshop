function overviewSpaceControllerInit($apiRequest, $page) {
          return $apiRequest.config("spaces/" + $page.routeParams.id).getData();
}

function overviewSpaceController($scope, $init) {
          $scope.space = $init;
}
