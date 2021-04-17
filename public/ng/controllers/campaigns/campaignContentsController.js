async function campaignContentsControllerInit($http, $page, $apiRequest) {
  return {
    contents: await $apiRequest.config("campaigns/" + $page.routeParams.id + '/contents').getData(),
  };
}

function campaignContentsController($scope, $page, $apiRequest, $init) {
    
  $scope.contents = $init.contents;


  $scope.titleContent = {};
  $scope.detailsContent = {};

  $scope.createUpdateTitleContent = $apiRequest.config({
    method: "PUT",
    url: "campaigns/" + $page.routeParams.id + "/contents",
    data: $scope.titleContent,
    
  },
  // function(response, data) {
  //     $page.reload();
  //   },
    );

  $scope.createUpdateDetailsContent = $apiRequest.config(
    {
      method: "PUT",
      url: "campaigns/" + $page.routeParams.id + "/contents",
      data: $scope.detailsContent,
    },
    // function (response, data) {
    //   $page.reload();
    // }
  );



}
