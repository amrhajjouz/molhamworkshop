// const { initial } = require("lodash");

async function editCampaignControllerInit($http, $page, $apiRequest) {
  return {
    object: await $apiRequest
      .config("campaigns/" + $page.routeParams.id)
      .getData(),
    places: await $apiRequest.config("places").getData(),
  };
}

function editCampaignController($scope, $page, $apiRequest, $init) {
  $scope.object = $init.object;
  $scope.places = $init.places;
  if (!$scope.object.places) $scope.object.places = [];

  $scope.updateCampaign = $apiRequest.config(
    {
      method: "PUT",
      url: "campaigns",
      data: $scope.object,
    },
    function (response, data) {}
  );
}
