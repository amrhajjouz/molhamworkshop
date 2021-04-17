async function eventContentsControllerInit($http, $page, $apiRequest) {
  return {
    contents: await $apiRequest.config("events/" + $page.routeParams.id + '/contents').getData(),
  };
}

function eventContentsController($scope, $page, $apiRequest, $init) {
    
    
  $scope.contents = $init.contents;

  $scope.titleContent = {};
  $scope.detailsContent = {};

  $scope.createUpdateTitleContent = $apiRequest.config({
    method: "PUT",
    url: "events/" + $page.routeParams.id + "/contents",
    data: $scope.titleContent,
  });

  $scope.createUpdateDetailsContent = $apiRequest.config({
    method: "PUT",
    url: "events/" + $page.routeParams.id + "/contents",
    data: $scope.detailsContent,
  });
}
