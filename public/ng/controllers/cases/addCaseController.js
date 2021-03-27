async function addCaseControllerInit($apiRequest) {
  return {
    countries: await $apiRequest.config("countries").getData(),
    categories: await $apiRequest
      .config("categories?created_for=Cases")
      .getData(),
    places: await $apiRequest.config("places").getData(),
  };
}



function addCaseController($scope, $location, $apiRequest, $page, $init) {
  $scope.statuses = [
    { id: "funded", name: "تم كفالتها" },
    { id: "unfunded", name: "غير مكفولة" },
    { id: "canceled", name: "ملغاة" },
    { id: "spent", name: "تم صرفها" },
  ];

  $scope.object = {
    target: {
      required: 1,
      visible: true,
      documented: false,
      archived: false,
      beneficiaries_count: 1,
      category_id: null,
    },
    place_id: null,
    status: "unfunded",
  };

  $scope.countries = $init.countries;
  $scope.categories = $init.categories;
  $scope.places = $init.places;

  $scope.createCase = $apiRequest.config(
    {
      method: "POST",
      url: "cases",
      data: $scope.object,
    },
    function (response, data) {
      $page.navigate("cases.overview", { id: data.id });
    }
  );
}
