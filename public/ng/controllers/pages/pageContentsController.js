async function pageContentsControllerInit($http, $page, $apiRequest) {
  return {
    contents: await $apiRequest.config("pages/" + $page.routeParams.id + '/contents').getData(),
  };
}

function pageContentsController($scope, $page, $apiRequest, $init) {
    
  $scope.contents = $init.contents;

  $scope.createUpdatePageContents = $apiRequest.config(
    {
      method: "PUT",
      url: "pages/" + $page.routeParams.id + "/contents",
      data: $scope.contents,
    },
    function (response, data) {}
  );
}
