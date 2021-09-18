function editEmployeeControllerInit($page, $apiRequest) {
          return $apiRequest
                    .config("employees/" + $page.routeParams.id)
                    .getData();
}

function editEmployeeController($scope, $apiRequest, $init, $page) {
          $scope.employee = $init;
          console.log($scope.employee);
          $scope.updateEmployee = $apiRequest.config(
                    {
                              method: "PUT",
                              url: "employees",
                              data: $scope.employee,
                    },
                    function (response, data) {
                              $page.navigate("employees.overview", {
                                        id: data.id,
                              });
                    }
          );
}
