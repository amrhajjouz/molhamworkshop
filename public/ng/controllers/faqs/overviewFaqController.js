function overviewFaqControllerInit($apiRequest, $page) {
  return $apiRequest.config("faqs/" + $page.routeParams.id).getData();
}

function overviewFaqController($scope, $page, $apiRequest, $init) {
  $scope.faq = $init;
}
