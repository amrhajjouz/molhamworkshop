function overviewCaseControllerInit($apiRequest, $page) {
  return $apiRequest.config("programs/medical/cases/" + $page.routeParams.id).getData();
}

function overviewCaseController($scope, $page, $apiRequest, $init) {
  $scope.case = $init;
}
