async function addPageControllerInit($apiRequest) {
  return {
  };
}

function addPageController($scope, $location, $apiRequest, $page, $init) {

  $scope.page = {
    url:null,
  };

  $scope.createPage = $apiRequest.config(
    {
      method: "POST",
      url: "pages",
      data: $scope.page,
    },
    function (response, data) {
      $page.navigate("pages.overview", { id: data.id });
    }
  );
}
