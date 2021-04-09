async function editShortcutControllerInit($http, $page, $apiRequest) {
  return {
    shortcut: await $apiRequest.config("shortcuts/" + $page.routeParams.id).getData(),
  };
}

function editShortcutController($scope, $page, $apiRequest, $init) {
  $scope.shortcut = $init.shortcut;

  $scope.updateShortcut = $apiRequest.config(
    {
      method: "PUT",
      url: "shortcuts",
      data: $scope.shortcut,
    },
    function (response, data) {}
  );
}
