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
    $scope.selectedPermission = {
        permissions_ids: null,
        role_id: $scope.roleId,
    };

    $scope.unassignPermission = async (permissionID) => {

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
                    $page.reload();
                }
            )
            .send();
    };

  


  $scope.assignPermission = $apiRequest.config(
      {
          method: "POST",
          url: "roles/" + $scope.roleId + "/assign",
          data:$scope.selectedPermission
      },
      function (response, data) {

           $("#permission-modal").on("hidden.bs.modal", function (e) {
               $page.reload();
           });


          $("#permission-modal").modal("hide");
      }
  );

  $scope.showModal = function () {
      $("#permission-modal").modal("show");
  };
}
