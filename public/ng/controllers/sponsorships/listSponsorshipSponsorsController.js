async function listSponsorshipSponsorsControllerInit(
  $http,
  $page,
  $apiRequest
) {
  return {
    sponsors: await $apiRequest
      .config("sponsorships/" + $page.routeParams.id + "/sponsors")
      .getData(),
    object: await $apiRequest
      .config("sponsorships/" + $page.routeParams.id)
      .getData(),
  };
}

function listSponsorshipSponsorsController($scope, $page, $apiRequest, $init) {
  $scope.sponsors = $init.sponsors;
  $scope.object = $init.object;

  //initial value for sponsor
  $scope.sponsor = {
    donor_id: null,
    percentage: null,
    purpose_type: "\\App\\Models\\Sponsorship",
    purpose_id: $page.routeParams.id,
  };

  $scope.getMaxPercentageOnUpdate = () => {
    if (!$scope.selected_object) return 0;
    let sponsors = $scope.sponsors;
    sponsors = sponsors.filter((item) => item.id != $scope.selected_object.id);

    let total = 0;

    sponsors.forEach((element) => {
      total += element.percentage;
    });

    return 100 - total;
  };

  $scope.createUpdateSponsorshipSponsor = $apiRequest.config(
    {
      method: "POST",
      url: `sponsors`,
      data: $scope.sponsor,
    },
    function (response, data) {
      if ($scope.currentSponsorModalAction == "edit") {
        $scope.sponsors[
          $scope.sponsors.findIndex((a) => a.id === data.id)
        ] = data;
      } else {
        $scope.sponsors.push(data);
      }

      //calculate percentage to complete after create or update
      $scope.calculatePercentageToComplete();

      $("#sponsor-modal").modal("hide");

      // reinitialize sponsor to default value after create or update
      $scope.sponsor = {
        donor_id: null,
        percentage: null,
        purpose_type: "\\App\\Models\\Sponsorship",
        purpose_id: $page.routeParams.id,
      };
    }
  );

  $scope.currentSponsorModalAction = "add";

  $scope.showSponsorModal = function (action, data = {}) {
    $scope.currentSponsorModalAction = action;
    if (action == "add") {
      $scope.createUpdateSponsorshipSponsor.config.method = "POST";
    } else {
      $scope.createUpdateSponsorshipSponsor.config.method = action = "PUT";
      $scope.sponsor = angular.copy(data);
    }
    $("#sponsor-modal").modal("show");
  };

  //  refresh percentage to complete on edit or create
  $scope.calculatePercentageToComplete = () => {
    let percentageToComplete = 0;
    $scope.sponsors.forEach((i) => (percentageToComplete += i.percentage));
    $scope.object.percentage_to_complete = 100 - percentageToComplete;
  };

  //calculate acceptable max range for percentage on update
  $scope.getMaxRangeOnUpdate = (item) => {
    if ($scope.currentSponsorModalAction == "add") {
      return $scope.object.percentage_to_complete;
    }
    let sponsores = $scope.sponsors.filter((i) => i.id != item.id);

    let max = 0;
    sponsores.forEach((i) => {
      max += i.percentage;
    });
    return 100 - max;
  };
}
