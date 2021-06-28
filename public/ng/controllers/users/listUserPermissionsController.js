async function listUserPermissionsControllerInit($datalist, $location, $apiRequest, $page) {

  let Permissions = await $apiRequest.config(`users/${$page.routeParams.id}/permissions`, true).getData();

  let fakerPaginator = {
    currentPage: 1,
    data: [],
    filtering: false,
    filters: {},
    lastPageUrl: '',
    firstPageUrl: '',
    from: 1,
    lastPage: 1,
    to: 1,
    loaded: true,
    loading: false,
    pages: [1],
    params: {},
    total: 1,
    q: '',
    search: function (q) {},
  };
  fakerPaginator.data = Permissions;
  fakerPaginator.total = Permissions.length;

  return fakerPaginator;
}

function listUserPermissionsController($scope, $init, $page, $apiRequest) {
  $scope.userId = $page.routeParams.id;
  $scope.permissions = $init;
  $scope.selectedPermission = {
      permissions_ids: null,
      user_id: $scope.userId,
  };

  $scope.unassignPermission = async (permissionID) => {
    if (!confirm('هل تريد التأكيد على إلغاء إسناد هذه الصلاحية ؟ ')) return;

    const data = {
      user_id: $scope.userId,
      permission_id: permissionID,
    };

    $apiRequest
      .config(
        {
          method: 'POST',
          url: 'users/' + $scope.userId + '/unassign_permission',
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
      method: 'POST',
      url: 'users/' + $scope.userId + '/assign_permissions',
      data: $scope.selectedPermission,
    },
    function (response, data) {
      $('#permission-modal').on('hidden.bs.modal', function (e) {
        $page.reload();
      });

      $('#permission-modal').modal('hide');
    }
  );

  $scope.showModal = function () {
    $('#permission-modal').modal('show');
  };
}
