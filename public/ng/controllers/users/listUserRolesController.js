async function listUserRolesControllerInit($datalist, $location, $apiRequest, $page) {

  let roles = await $apiRequest.config(`users/${$page.routeParams.id}/roles`, true).getData();

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
  roles.forEach(r=> r.title = JSON.parse(r.title));
  fakerPaginator.data = roles;
  fakerPaginator.total = roles.length;

  return fakerPaginator;
}

function listUserRolesController($scope, $init, $page, $apiRequest) {
  $scope.userId = $page.routeParams.id;
  $scope.roles = $init;
  $scope.selectedRoles = {
    roles_ids: [],
    user_id: $scope.userId,
  };

  $scope.unassignRole = async (roleId) => {
    if (!confirm('هل تريد التأكيد على إلغاء إسناد هذا الدور  ؟ ')) return;

    const data = {
      user_id: $scope.userId,
      role_id: roleId,
    };

    $apiRequest
      .config(
        {
          method: 'POST',
          url: 'users/' + $scope.userId + '/unassign_role',
          data: data,
        },
        function (response, data) {
          $page.reload();
        }
      )
      .send();
  };

  $scope.assignRoles = $apiRequest.config(
    {
      method: 'POST',
      url: 'users/' + $scope.userId + '/assign_roles',
      data: $scope.selectedRoles,
    },
    function (response, data) {
      $('#role-modal').on('hidden.bs.modal', function (e) {
        $page.reload();
      });

      $('#role-modal').modal('hide');
    }
  );

  $scope.showModal = function () {
    $('#role-modal').modal('show');
  };
}
