async function blogContentsControllerInit($http, $page, $apiRequest) {
  return {
    contents: await $apiRequest.config("blogs/" + $page.routeParams.id + '/contents').getData(),
  };
}

function blogContentsController($scope, $page, $apiRequest, $init) {
    
  $scope.contents = $init.contents;

   $scope.contents = $init.contents;

   $scope.titleContent = {};
   $scope.descriptionContent = {};
   $scope.bodyContent = {};

   $scope.createUpdateTitleContent = $apiRequest.config({
     method: "PUT",
     url: "blogs/" + $page.routeParams.id + "/contents",
     data: $scope.titleContent,
   });

   $scope.createUpdateDescriptionContent = $apiRequest.config({
     method: "PUT",
     url: "blogs/" + $page.routeParams.id + "/contents",
     data: $scope.descriptionContent,
   });

   $scope.createUpdateBodyContent = $apiRequest.config({
     method: "PUT",
     url: "blogs/" + $page.routeParams.id + "/contents",
     data: $scope.bodyContent,
   });
}
