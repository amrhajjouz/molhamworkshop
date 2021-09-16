async function editCaseControllerInit($http, $page, $apiRequest) {
  return {
    case: await $apiRequest.config("cases/" + $page.routeParams.id).getData(),
  };
}

function editCaseController($scope, $page, $apiRequest, $init) {
    
  $scope.case = $init.case;

  $scope.statuses = [
    { id: "funded", name: "تم كفالتها" },
    { id: "unfunded", name: "غير مكفولة" },
    { id: "canceled", name: "ملغاة" },
    { id: "spent", name: "تم صرفها" },
  ];

  $scope.updateCaseRequest = $apiRequest.config(
    {
      method: "PUT",
      url: "cases",
      data: $scope.case,
    },
    function (response, data) {}
  );
}
