async function addShortcutControllerInit($apiRequest) {
  return {
  };
}

function addShortcutController($scope, $location, $apiRequest, $page, $init) {

  $scope.shortcut = {
    path: null,
    contents: {
      title: {
        ar: null,
      },
      description: {
        ar: null,
      },
    },
  };

  $scope.createShortcut = $apiRequest.config(
    {
      method: "POST",
      url: "shortcuts",
      data: $scope.shortcut,
    },
    function (response, data) {
      $page.navigate("shortcuts.overview", { id: data.id });
    }
  );
}
