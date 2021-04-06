async function eventContentsControllerInit($http, $page, $apiRequest) {
  return {
    contents: await $apiRequest.config("events/" + $page.routeParams.id + '/contents').getData(),
  };
}

function eventContentsController($scope, $page, $apiRequest, $init) {
    
  $scope.contents = $init.contents;

  $scope.createUpdateEventContents = $apiRequest.config(
    {
      method: "PUT",
      url: "events/" + $page.routeParams.id + "/contents",
      data: $scope.contents,
    },
    function (response, data) {}
  );
}
