async function editPublisherControllerInit($http, $page, $apiRequest) {
  return {
    publisher: await $apiRequest
      .config("publishers/" + $page.routeParams.id)
      .getData(),
  };
}

function editPublisherController($scope, $page, $apiRequest, $init) {
  $scope.publisher = $init.publisher;

  $scope.updatePublisher = $apiRequest.config(
    {
      method: "PUT",
      url: "publishers",
      data: $scope.publisher,
    },
    function (response, data) {}
  );
}
