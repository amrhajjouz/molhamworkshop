async function campaignContentsControllerInit($http, $page, $apiRequest) {
  return {
    contents: await $apiRequest.config("campaigns/" + $page.routeParams.id + '/contents').getData(),
  };
}

function campaignContentsController($scope, $page, $apiRequest, $init) {
    
  $scope.contents = $init.contents;

  $scope.createUpdateCampaignContents = $apiRequest.config(
    {
      method: "PUT",
      url: "campaigns/" + $page.routeParams.id +'/contents',
      data: $scope.contents,
    },
    function (response, data) {}
  );
}
