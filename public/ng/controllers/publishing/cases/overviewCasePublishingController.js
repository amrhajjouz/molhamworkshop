function overviewCasePublishingControllerInit($apiRequest, $page) {
  return $apiRequest.config("publishing/cases/" + $page.routeParams.id).getData();
}

function overviewCasePublishingController($scope, $page, $apiRequest, $init) {
  $scope.case = $init;
}
