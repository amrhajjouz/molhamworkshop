async function addConstantControllerInit($apiRequest) {
  return {
  };
}

function addConstantController($scope, $location, $apiRequest, $page, $init) {

  $scope.constant = {
    plaintext: false,
    content:{
      locale:"ar",
      name:null,
      value:null,
    }
  };

  $scope.createConstant = $apiRequest.config(
    {
      method: "POST",
      url: "constants",
      data: $scope.constant,
    },
    function (response, data) {
      $page.navigate("constants.overview", { id: data.id });
    }
  );
}
