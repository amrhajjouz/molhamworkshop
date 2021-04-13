async function editPageControllerInit($http, $page, $apiRequest) {
  const page = await $apiRequest
    .config("pages/" + $page.routeParams.id)
    .getData();

  return {
    page: page,
  };
}

function editPageController($scope, $page, $apiRequest, $init) {
  $scope.page = $init.page;

  $scope.updatePage = $apiRequest.config(
    {
      method: "PUT",
      url: "pages",
      data: $scope.page,
    },
    function (response, data) {}
  );
}
