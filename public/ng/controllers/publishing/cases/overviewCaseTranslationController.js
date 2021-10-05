function overviewCaseTranslationControllerInit($apiRequest, $page) {
  return $apiRequest.config("translation/cases/" + $page.routeParams.id).getData();
}

function overviewCaseTranslationController($scope, $page, $apiRequest, $init) {
  $scope.case = $init;
}
