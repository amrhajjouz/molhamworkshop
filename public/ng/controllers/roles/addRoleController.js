function addRoleController($scope, $apiRequest, $page) {
    $scope.role = {
        name:null,
        ar_name:null,
    };

    $scope.createRole = $apiRequest.config(
        {
            method: "POST",
            url: "roles",
            data: $scope.role,
        },
        function (response, data) {
            $page.navigate("roles.overview", { id: data.id });
        }
    );
}
