function listEmployeeControllerInit($page, $datalist) {
          return $datalist("employees", true).load();
}

function listEmployeeController($scope, $init, $apiRequest, $page) {
          $scope.employees = $init;
          console.log($scope);
          $scope.deleteEmployee = (id) => {
                    $apiRequest
                              .config(
                                        {
                                                  method: "DELETE",
                                                  url: "employees/" + id,
                                        },
                                        function (response, data) {
                                                  $page.reload();
                                        }
                              )
                              .send();
          };
}
