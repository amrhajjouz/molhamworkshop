async function blogContentsControllerInit($http, $page, $apiRequest) {
  return {
    contents: await $apiRequest.config("blogs/" + $page.routeParams.id + '/contents').getData(),
  };
}

function blogContentsController($scope, $page, $apiRequest, $init) {
    
  $scope.contents = $init.contents;

  $scope.createUpdateBlogContents = $apiRequest.config(
    {
      method: "PUT",
      url: "blogs/" + $page.routeParams.id + "/contents",
      data: $scope.contents,
    },
    function (response, data) {}
  );
}
