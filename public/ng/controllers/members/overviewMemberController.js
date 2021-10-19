function overviewMemberControllerInit($apiRequest, $page) {
  return $apiRequest.config("members/" + $page.routeParams.id).getData();
}

function overviewMemberController($scope, $page, $apiRequest, $init) {
  $scope.member = $init;
}