function overviewShortcutControllerInit($apiRequest, $page) {
  return $apiRequest.config("shortcuts/" + $page.routeParams.id).getData();
}

function overviewShortcutController($scope, $page, $apiRequest, $init) {
  $scope.shortcut = $init;
}
