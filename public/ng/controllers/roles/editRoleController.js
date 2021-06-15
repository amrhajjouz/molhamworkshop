function editRoleControllerInit($page, $apiRequest) {
    return $apiRequest.config("roles/" + $page.routeParams.id).getData();
}
function editRoleController($scope, $page, $apiRequest, $init) {
    $scope.role = $init;
    $scope.updateRole = $apiRequest.config(
        {
            method: "PUT",
            url: "roles",
            data: $scope.role,
        },
        function (response, data) {}
    );
}
