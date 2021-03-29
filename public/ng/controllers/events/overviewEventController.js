function overviewEventControllerInit($apiRequest, $page) {
  return $apiRequest.config("events/" + $page.routeParams.id).getData();
}

function overviewEventController($scope, $page, $apiRequest, $init) {
  $scope.object = $init;

  $scope.updateEvent = $apiRequest.config(
    {
      method: "POST",
      url: "events",
      data: $scope.object,
    },
    function (response, data) {}
  );
}
