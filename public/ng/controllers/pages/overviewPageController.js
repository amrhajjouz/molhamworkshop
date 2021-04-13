function overviewPageControllerInit($apiRequest, $page) {
  return $apiRequest.config("pages/" + $page.routeParams.id).getData();
}

function overviewPageController($scope, $page, $apiRequest, $init) {
  $scope.page = $init;

  $scope.updatePage = $apiRequest.config(
    {
      method: "POST",
      url: "pages",
      data: $scope.page,
    },
    function (response, data) {}
  );
}
