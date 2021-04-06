async function fundraiserContentsControllerInit($http, $page, $apiRequest) {
  return {
    contents: await $apiRequest.config("fundraisers/" + $page.routeParams.id + '/contents').getData(),
  };
}

function fundraiserContentsController($scope, $page, $apiRequest, $init) {
    
  $scope.contents = $init.contents;

  $scope.createUpdateFundraiserContents = $apiRequest.config(
    {
      method: "PUT",
      url: "fundraisers/" + $page.routeParams.id + "/contents",
      data: $scope.contents,
    },
    function (response, data) {}
  );
}
