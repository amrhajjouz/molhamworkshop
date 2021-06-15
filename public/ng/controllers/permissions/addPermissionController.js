function addPermissionController($scope, $apiRequest, $page) {
    $scope.permission = {};

    $scope.createPermission = $apiRequest.config(
        {
            method: "POST",
            url: "permissions",
            data: $scope.permission,
        },
        function (response, data) {
            $page.navigate("permissions.overview", { id: data.id });
        }
    );
}
