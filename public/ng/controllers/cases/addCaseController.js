async function addCaseControllerInit($apiRequest) {
  return {
    countries: await $apiRequest.config("countries").getData(),
    categories: await $apiRequest
      .config("categories?created_for=Cases")
      .getData(),
    // places: await $apiRequest.config("places").getData(),
  };
}



function addCaseController($scope, $location, $apiRequest, $page, $init) {
  $scope.statuses = [
    { id: "funded", name: "تم كفالتها" },
    { id: "unfunded", name: "غير مكفولة" },
    { id: "canceled", name: "ملغاة" },
    { id: "spent", name: "تم صرفها" },
  ];

  $scope.case = {
    country_code:null,
    beneficiary_name:null,
    status: "unfunded",
    target: {
      beneficiaries_count: 1,
      hidden: false,
      required: 1,
      category_id: null,
    },
    // place_id: null,
    // admins_ids: [],
  };

  $scope.countries = $init.countries;
  $scope.categories = $init.categories;
  // $scope.places = $init.places;

  $scope.createCaseRequest = $apiRequest.config(
    {
      method: "POST",
      url: "cases",
      data: $scope.case,
    },
    function (response, data) {
      $page.navigate("cases.overview", { id: data.id });
    }
  );
}
