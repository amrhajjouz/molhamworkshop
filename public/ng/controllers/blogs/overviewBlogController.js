function overviewBlogControllerInit($apiRequest, $page) {
  return $apiRequest.config("blogs/" + $page.routeParams.id).getData();
}

function overviewBlogController($scope, $page, $apiRequest, $init) {
  $scope.blog = $init;
}
