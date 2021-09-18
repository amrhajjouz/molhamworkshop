function addUserController($scope, $location, $apiRequest, $page) {
          $scope.user = {};
          console.log($scope.user);

          $scope.createUser = $apiRequest.config(
                    {
                              method: "POST",
                              url: "users",
                              data: $scope.user,
                    },
                    function (response, data) {
                              $page.navigate("users.overview", { id: data.id });
                    }
          );
}
