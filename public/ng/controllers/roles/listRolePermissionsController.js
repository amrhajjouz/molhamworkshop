async function listRolePermissionsControllerInit($datalist, $location , $apiRequest , $page) {
    // return $datalist("roles", true).load();

    let Permissions = await $apiRequest
        .config(`roles/${$page.routeParams.id}/permissions`, true)
        .getData();


  let fakerPaginator = {
      currentPage: 1,
      data: [],
      filtering: false,
      filters: {},
      lastPageUrl: "",
      firstPageUrl: "",
      from: 1,
      lastPage: 1,
      to: 1,
      loaded: true,
      loading: false,
      pages: [1],
      params: {},
      total: 1,
      q: "",
      search: function (q) {},
  };
  fakerPaginator.data = Permissions;
  fakerPaginator.total = Permissions.length;

  return fakerPaginator;


}

function listRolePermissionsController($scope, $init, $page, $apiRequest) {
    $scope.roleId = $page.routeParams.id;
    $scope.permissions = $init;

    $scope.unassignPermission = async (permissionID) => {
        console.log({ permissionID });
        console.log({ roleId: $scope.roleId });

        if (!confirm("هل تريد التأكيد على إلغاء إسناد هذه الصلاحية ؟ ")) return;

        const data = {
            role_id: $scope.roleId,
            permission_id: permissionID,
        };

        $apiRequest
            .config(
                {
                    method: "POST",
                    url: "roles/" + $scope.roleId + "/unassign",
                    data: data,
                },
                function (response, data) {
                    console.log({ data });
                    $page.reload();
                }
            )
            .send();
    };
}
