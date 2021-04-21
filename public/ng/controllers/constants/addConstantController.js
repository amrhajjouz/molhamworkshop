async function addConstantControllerInit($apiRequest) {
  return {
  };
}

function addConstantController($scope, $location, $apiRequest, $page, $init) {

  $scope.constant = {
    name:null,
    plaintext: false,
    content:{
      locale:"ar",
      name:"body",
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
