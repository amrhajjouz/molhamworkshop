function overviewFundraiserControllerInit($apiRequest, $page) {
  return $apiRequest.config("fundraisers/" + $page.routeParams.id).getData();
}

function overviewFundraiserController($scope, $page, $apiRequest, $init) {
  $scope.object = $init;

}
