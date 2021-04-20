async function listShortcutKeywordsControllerInit($http, $page, $apiRequest) {
  const keywords = await $apiRequest
    .config("shortcuts/" + $page.routeParams.id + "/keys")
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

  fakerPaginator.data = keywords;
  fakerPaginator.total = keywords.length;

  return {
    keywords: fakerPaginator,
  };
}

function listShortcutKeywordsController($scope, $page, $apiRequest, $init) {
  $scope.keywords = $init.keywords;
  $scope.defaultKeywordModel = {
    shortcut_id: $page.routeParams.id,
    id: null,
    name: "key",
    value: null,
    locale: "ar", //ToDo: make dropdown select locale
  };

  $scope.key = angular.copy($scope.defaultKeywordModel);

  $scope.contents = {};
  $scope.selectedKey = {};
  $scope.keywordContent = {};

  $scope.createUpdateShortcutContent = $apiRequest.config(
    {
      method: "POST",
      url: `shortcuts_keys/${$page.routeParams.id}`,
      data: $scope.key,
    },
    function (response, data) {
      $("#key-modal").on("hidden.bs.modal", function (e) {
        $page.reload();
      });
      $("#update-modal").on("hidden.bs.modal", function (e) {
        $page.reload();
      });
      $("#key-modal").modal("hide");
      $("#update-modal").modal("hide");

      // reinitialize key to default value after create or update
      $scope.key = angular.copy($scope.defaultKeywordModel);
    }
  );

  // $scope.showContent = async (id) => {
  //   $apiRequest.config(
  //     {
  //       method: "get",
  //       url: `shortcut_keys/${id}`,
  //       data: $scope.key,
  //     },
  //     function (response, data) {
  //       $scope.contents = data;
  //         $scope.createUpdateShortcutContent.config.method = action = "PUT";
  //         $scope.createUpdateShortcutContent.config.url = `api/shortcuts_keys/${id}/contents`;
  //         $("#update-modal").modal("show");
  //       console.log({data})
  //       console.log({response})

  //     }
  //   ).getData();
  //   $scope.currentModalAction = "edit";
  // };

  $scope.showModal = function (action, data = {}) {
    $scope.currentModalAction = action;
    switch (action) {
      case "add":
        $scope.key = angular.copy($scope.defaultKeywordModel); //reinitial object , maybu user click on edit then create ,,, to reset Keyword object
        $scope.createUpdateShortcutContent.config.method = "POST";
        $("#key-modal").modal("show");
        break;
      case "edit":
        $scope.selectedKey = data;
        $scope.createUpdateShortcutContent.config.method = action = "PUT";
        $scope.createUpdateShortcutContent.config.url = `api/shortcuts_keys/${$scope.selectedKey.id}/contents`;
        $scope.contents = {};
        $scope.contents = data.contents;
        $("#update-modal").modal("show");
        break;

      default:
        break;
    }
  };
}
