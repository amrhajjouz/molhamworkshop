function overviewEmployeeControllerInit($apiRequest, $page) {
          console.log($page.routeParams.id);
          return $apiRequest
                    .config("employees/" + $page.routeParams.id)
                    .getData();
}

function overviewEmployeeController($scope, $init) {
          console.log($init);
          $scope.employee = $init;
}
