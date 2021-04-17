async function studentContentsControllerInit($http, $page, $apiRequest) {
  return {
    contents: await $apiRequest.config("students/" + $page.routeParams.id + '/contents').getData(),
  };
}

function studentContentsController($scope, $page, $apiRequest, $init) {
    
  $scope.contents = $init.contents;

  $scope.titleContent = {};
  $scope.detailsContent = {};

  $scope.createUpdateTitleContent = $apiRequest.config({
    method: "PUT",
    url: "students/" + $page.routeParams.id + "/contents",
    data: $scope.titleContent,
  });

  $scope.createUpdateDetailsContent = $apiRequest.config({
    method: "PUT",
    url: "students/" + $page.routeParams.id + "/contents",
    data: $scope.detailsContent,
  });
}
