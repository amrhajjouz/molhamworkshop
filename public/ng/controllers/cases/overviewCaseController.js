function overviewCaseControllerInit($apiRequest, $page) {
  return $apiRequest.config("cases/" + $page.routeParams.id).getData();
}

function overviewCaseController($scope, $page, $apiRequest, $init) {
  $scope.case = $init;
  $scope.updateUser = $apiRequest.config({ method: "POST", url: "cases", data: $scope.case, }, function (response, data) { }

  );
}
