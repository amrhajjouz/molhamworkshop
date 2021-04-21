async function editConstantControllerInit($http, $page, $apiRequest) {
  return {
    constant: await $apiRequest
      .config("constants/" + $page.routeParams.id)
      .getData(),
  };
}

function editConstantController($scope, $page, $apiRequest, $init) {
  $scope.constant = $init.constant;
  $scope.contents = $init.constant.contents;
  $scope.bodyContent = {};

  $scope.updateConstant = $apiRequest.config(
    {
      method: "PUT",
      url: "constants",
      data: $scope.constant,
    },
    function (response, data) {}
  );

  $scope.createUpdateBodyContent = $apiRequest.config({
    method: "PUT",
    url: "constants/" + $page.routeParams.id + "/contents",
    data: $scope.bodyContent,
  });
}
