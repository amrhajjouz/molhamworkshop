async function fundraiserContentsControllerInit($http, $page, $apiRequest) {
  return {
    contents: await $apiRequest.config("fundraisers/" + $page.routeParams.id + '/contents').getData(),
  };
}

function fundraiserContentsController($scope, $page, $apiRequest, $init) {
    

  $scope.contents = $init.contents;

  $scope.titleContent = {};
  $scope.detailsContent = {};

  $scope.createUpdateTitleContent = $apiRequest.config({
    method: "PUT",
    url: "fundraisers/" + $page.routeParams.id + "/contents",
    data: $scope.titleContent,
  });

  $scope.createUpdateDetailsContent = $apiRequest.config({
    method: "PUT",
    url: "fundraisers/" + $page.routeParams.id + "/contents",
    data: $scope.detailsContent,
  });
}
