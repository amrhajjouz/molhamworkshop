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



  // /////////////////////// contents /////////////////////////

        $scope.contents = $init.shortcut.contents;
        $scope.defaultKey = {
          shortcut_id: $page.routeParams.id,
          content: {
            contentable_type: "\\AppModels\\ShortcutKey",
            contentable_id: null,
            locale: "ar",
            value: null,
          },
        };

        $scope.key = angular.copy($scope.defaultKey);

        $scope.titleContent = {};
        $scope.descriptionContent = {};

        $scope.createUpdateTitleContent = $apiRequest.config({
          method: "PUT",
          url: "shortcuts/" + $page.routeParams.id + "/contents",
          data: $scope.titleContent,
        });

        $scope.createUpdateDescriptionContent = $apiRequest.config({
          method: "PUT",
          url: "shortcuts/" + $page.routeParams.id + "/contents",
          data: $scope.descriptionContent,
        });
  
}
