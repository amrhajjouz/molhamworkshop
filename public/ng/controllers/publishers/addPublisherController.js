async function addPublisherControllerInit($apiRequest) {
  return {
  };
}

function addPublisherController($scope, $location, $apiRequest, $page, $init) {

  $scope.publisher = {
    contents: {
      name: {
        value: null,
        name: "name",
      },
      description: {
        value: null,
        name: "description",
      },
    },
  };

  $scope.createPublisher = $apiRequest.config(
    {
      method: "POST",
      url: "publishers",
      data: $scope.publisher,
    },
    function (response, data) {
      $page.navigate("publishers.overview", { id: data.id });
    }
  );
}
