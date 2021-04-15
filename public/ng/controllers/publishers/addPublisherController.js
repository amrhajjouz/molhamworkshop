async function addPublisherControllerInit($apiRequest) {
  return {
  };
}

function addPublisherController($scope, $location, $apiRequest, $page, $init) {

  $scope.publisher = {
    contents: {
      name: {
        ar: null,
      },
      description: {
        ar: null,
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
