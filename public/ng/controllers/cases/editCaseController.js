async function editCaseControllerInit($http, $page, $apiRequest) {
  return {
    object: await $apiRequest.config("cases/" + $page.routeParams.id).getData(),
    countries: await $apiRequest.config("countries").getData(),
    places: await $apiRequest.config("places").getData(),
  };
}

function editCaseController($scope, $page, $apiRequest, $init) {
    
  $scope.object = $init.object;
  $scope.countries = $init.countries;
  $scope.places = $init.places;
  if (!$scope.object.places) $scope.object.places = [];

  $scope.statuses = [
    { id: "funded", name: "تم كفالتها" },
    { id: "unfunded", name: "غير مكفولة" },
    { id: "canceled", name: "ملغاة" },
    { id: "spent", name: "تم صرفها" },
  ];

  $scope.updateCase = $apiRequest.config(
    {
      method: "PUT",
      url: "cases",
      data: $scope.object,
    },
    function (response, data) {}
  );
}
