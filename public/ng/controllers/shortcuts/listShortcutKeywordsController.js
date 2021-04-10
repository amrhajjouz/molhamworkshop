async function listShortcutKeywordsControllerInit($http, $page, $apiRequest) {

  const keywords = await $apiRequest
    .config("shortcuts/" + $page.routeParams.id + "/keywords")
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
        id:null,
        name:"keyword",
        value:null,
        locale:'ar', //ToDo: make dropdown select locale
  };

  $scope.keyword = angular.copy($scope.defaultKeywordModel);

  $scope.createUpdateShortcutKeywords = $apiRequest.config(
    {
      method: "POST",
      url: `shortcuts/${$page.routeParams.id}/keyword`,
      data: $scope.keyword,
    },
    function (response, data) {
      $("#keyword-modal").on("hidden.bs.modal", function (e) {
        $page.reload();
      });
      $("#keyword-modal").modal("hide");

      // reinitialize keyword to default value after create or update
      $scope.keyword = angular.copy($scope.defaultKeywordModel);
    }
  );

  $scope.currentModalAction = "add";

  $scope.showModal = function (action, data = {}) {
    $scope.currentModalAction = action;
    switch (action) {
      case "add":
        $scope.keyword = angular.copy($scope.defaultKeywordModel); //reinitial object , maybu user click on edit then create ,,, to reset Keyword object
        $scope.createUpdateShortcutKeywords.config.method = "POST";
        break;
      case "edit":
        $scope.createUpdateShortcutKeywords.config.method = action = "PUT";
        $scope.keyword = angular.copy(data);
        break;

      default:
        break;
    }
    $("#keyword-modal").modal("show");
  };
}
