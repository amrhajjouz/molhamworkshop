async function listShortcutKeywordsControllerInit($http, $page, $apiRequest) {
  // return {
  //   contents: await $apiRequest.config("shortcuts/" + $page.routeParams.id + '/keywords').getData(),
  // };




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

  $scope.createUpdateShortcutKeywords = $apiRequest.config(
    {
      method: "PUT",
      url: "shortcuts/" + $page.routeParams.id + "/keywords",
      data: $scope.keywords,
    },
    function (response, data) {}
  );
}
