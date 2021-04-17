async function pageContentsControllerInit($http, $page, $apiRequest) {
  return {
    contents: await $apiRequest.config("pages/" + $page.routeParams.id + '/contents').getData(),
  };
}

function pageContentsController($scope, $page, $apiRequest, $init) {
      $scope.contents = $init.contents;

      $scope.titleContent = {};
      $scope.descriptionContent = {};
      $scope.bodyContent = {};

      $scope.createUpdateTitleContent = $apiRequest.config({
        method: "PUT",
        url: "pages/" + $page.routeParams.id + "/contents",
        data: $scope.titleContent,
      });

      $scope.createUpdateDescriptionContent = $apiRequest.config({
        method: "PUT",
        url: "pages/" + $page.routeParams.id + "/contents",
        data: $scope.descriptionContent,
      });
    
      $scope.createUpdateBodyContent = $apiRequest.config({
        method: "PUT",
        url: "pages/" + $page.routeParams.id + "/contents",
        data: $scope.bodyContent,
      });
}
