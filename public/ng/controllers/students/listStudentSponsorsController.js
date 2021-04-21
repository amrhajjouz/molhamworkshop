async function listStudentSponsorsControllerInit(
  $http,
  $page,
  $apiRequest,
  $datalist
) {
  return {
    sponsors: await $datalist(
      "students/" + $page.routeParams.id + "/sponsors"
    ).load(),
    object: await $apiRequest
      .config("students/" + $page.routeParams.id)
      .getData(),
  };
}

function listStudentSponsorsController($scope, $page, $apiRequest, $init) {
  $scope.sponsors = $init.sponsors;
  $scope.object = $init.object;

  $scope.sponsor = {
    donor_id: null,
    percentage: null,
    purpose_type: "\\App\\Models\\Student",
    purpose_id: $page.routeParams.id,
  };

  $scope.get_max_percentage_on_update = () => {
    if (!$scope.selected_object) return 0;
    let sponsors = $scope.sponsors.data;
    sponsors = sponsors.filter((item) => item.id != $scope.selected_object.id);

    let total = 0;

    sponsors.forEach((element) => {
      total += element.percentage;
    });

    return 100 - total;
  };

  $scope.createStudentsSponsor = $apiRequest.config(
    {
      method: "POST",
      url: "sponsors",
      data: $scope.sponsor,
    },
    function (response, data) {
      $("#add-sponsors").modal("hide");
    }
  );
  $scope.showSponsorModal = function (action, data = {}) {
    $scope.currentSponsorModalAction = action;
    if (action == "add") {
      $scope.createUpdateStudentSponsor.config.method = "POST";
    } else {
      $scope.createUpdateStudentSponsor.config.method = action = "PUT";
      $scope.sponsor = angular.copy(data);
    }
    $("#sponsor-modal").modal("show");
  };

  $scope.createUpdateStudentSponsor = $apiRequest.config(
    {
      method: "POST",
      url: `sponsors`,
      data: $scope.sponsor,
    },
    function (response, data) {
      if ($scope.currentSponsorModalAction == "edit") {
        $scope.sponsors.data[
          $scope.sponsors.data.findIndex((a) => a.id === data.id)
        ] = data;
      } else {
        $scope.sponsors.data.push(data);
        $scope.sponsors.total ++;
      }

      $scope.calculatePercentageToComplete();
      $("#sponsor-modal").modal("hide");

      $scope.sponsor = {
        donor_id: null,
        percentage: null,
        purpose_type: "\\App\\Models\\Student",
        purpose_id: $page.routeParams.id,
      };
    }
  );

  //  refresh percentage to complete on edit or create
  $scope.calculatePercentageToComplete = () => {
    let percentageToComplete = 0;
    $scope.sponsors.data.forEach((i) => (percentageToComplete += i.percentage));
    $scope.object.percentage_to_complete = 100 - percentageToComplete;
  };

  //calculate acceptable max range for percentage on update
  $scope.getMaxRangeOnUpdate = (item) => {
    if ($scope.currentSponsorModalAction == "add") {
      return $scope.object.percentage_to_complete;
    }
    let sponsores = $scope.sponsors.data.filter((i) => i.id != item.id);

    let max = 0;
    sponsores.forEach((i) => {
      max += i.percentage;
    });
    return 100 - max;
  };
}
