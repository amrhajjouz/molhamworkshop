async function caseContentsControllerInit($http, $page, $apiRequest) {
  return {
    contents: await $apiRequest
      .config("cases/" + $page.routeParams.id + "/contents")
      .getData(),
  };
}

function caseContentsController($scope, $page, $apiRequest, $init) {
  $scope.contents = $init.contents;

  $scope.titleContent = {};
  $scope.detailsContent = {};

  $scope.createUpdateTitleContent = $apiRequest.config({
    method: "PUT",
    url: "cases/" + $page.routeParams.id + "/contents",
    data: $scope.titleContent,
  });

  $scope.createUpdateDetailsContent = $apiRequest.config({
    method: "PUT",
    url: "cases/" + $page.routeParams.id + "/contents",
    data: $scope.detailsContent,
  });
}
