async function sponsorshipContentsControllerInit($http, $page, $apiRequest) {
  return {
    contents: await $apiRequest
      .config("sponsorships/" + $page.routeParams.id + "/contents")
      .getData(),
  };
}

function sponsorshipContentsController($scope, $page, $apiRequest, $init) {
  $scope.contents = $init.contents;

  $scope.titleContent = {};
  $scope.detailsContent = {};

  $scope.createUpdateTitleContent = $apiRequest.config({
    method: "PUT",
    url: "sponsorships/" + $page.routeParams.id + "/contents",
    data: $scope.titleContent,
  });

  $scope.createUpdateDetailsContent = $apiRequest.config({
    method: "PUT",
    url: "sponsorships/" + $page.routeParams.id + "/contents",
    data: $scope.detailsContent,
  });
}
