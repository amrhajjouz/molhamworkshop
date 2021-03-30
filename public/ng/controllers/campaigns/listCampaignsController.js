async function listCampaignsControllerInit($datalist) {
  return await $datalist("campaigns", true).load();
}

function listCampaignsController($scope, $init) {
  $scope.campaigns = $init;
}
