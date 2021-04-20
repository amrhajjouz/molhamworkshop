async function publisherContentsControllerInit($http, $page, $apiRequest) {
  return {
    contents: await $apiRequest.config("publishers/" + $page.routeParams.id + '/contents').getData(),
  };
}

function publisherContentsController($scope, $page, $apiRequest, $init) {
      $scope.contents = $init.contents;

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
