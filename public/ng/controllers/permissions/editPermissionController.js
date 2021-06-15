function editPermissionControllerInit($page, $apiRequest) {
    return $apiRequest.config("permissions/" + $page.routeParams.id).getData();
}
function editPermissionController($scope, $page, $apiRequest, $init) {
    $scope.permission = $init;
    $scope.updatePermission = $apiRequest.config(
        {
            method: "PUT",
            url: "permissions",
            data: $scope.permission,
        },
        function (response, data) {}
    );
}
