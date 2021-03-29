function overviewCampaignControllerInit($apiRequest, $page) {
  return $apiRequest.config("campaigns/" + $page.routeParams.id).getData();
}

function overviewCampaignController($scope, $page, $apiRequest, $init) {
  $scope.object = $init;

  $scope.updateCampaign = $apiRequest.config(
    {
      method: "POST",
      url: "campaigns",
      data: $scope.object,
    },
    function (response, data) {}
  );
}
