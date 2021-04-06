async function studentContentsControllerInit($http, $page, $apiRequest) {
  return {
    contents: await $apiRequest.config("students/" + $page.routeParams.id + '/contents').getData(),
  };
}

function studentContentsController($scope, $page, $apiRequest, $init) {
    
  $scope.contents = $init.contents;

  $scope.createUpdateStudentContents = $apiRequest.config(
    {
      method: "PUT",
      url: "students/" + $page.routeParams.id + "/contents",
      data: $scope.contents,
    },
    function (response, data) {}
  );
}
