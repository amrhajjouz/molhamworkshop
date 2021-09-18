function addEmployeeControllerInit() {
          return [];
}

function addEmployeeController($scope, $apiRequest, $page) {
          $scope.employee = {};
          console.log($scope.employee);
          $scope.createEmployee = $apiRequest.config(
                    {
                              method: "POST",
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
