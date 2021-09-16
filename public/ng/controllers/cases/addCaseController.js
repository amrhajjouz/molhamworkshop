async function addCaseControllerInit($apiRequest) {
  return {
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
    },
    place_id: null,
  };


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
