async function editPublisherControllerInit($http, $page, $apiRequest) {
  return {
    publisher: await $apiRequest
      .config("publishers/" + $page.routeParams.id)
      .getData(),
  };
}

function editPublisherController($scope, $page, $apiRequest, $init) {
  $scope.publisher = $init.publisher;


      $scope.contents = $init.publisher.contents;

      $scope.descriptionContent = {};
      $scope.nameContent = {};

      $scope.createUpdateNameContent = $apiRequest.config({
        method: "PUT",
        url: "publishers/" + $page.routeParams.id + "/contents",
        data: $scope.nameContent,
      });

      $scope.createUpdateDescriptionContent = $apiRequest.config({
        method: "PUT",
        url: "publishers/" + $page.routeParams.id + "/contents",
        data: $scope.descriptionContent,
      });
}
