async function listSponsorshipSponsorsControllerInit(
  $http,
  $page,
  $apiRequest
) {
  const sponsors = await $apiRequest
    .config("sponsorships/" + $page.routeParams.id + "/sponsors")
    .getData();

  const object = await $apiRequest
    .config("sponsorships/" + $page.routeParams.id)
    .getData();

  const init = {
    sponsors: sponsors,
    object: object,
  };
  return init;
}

function listSponsorshipSponsorsController($scope, $page, $apiRequest, $init) {
  $scope.sponsors = $init.sponsors;
  $scope.object = $init.object;
  $scope.selected_object = {};

  $scope.sponsor = {
    donor_id: null,
    percentage: null,
    purpose_type: "\\App\\Models\\Sponsorship",
    purpose_id: $page.routeParams.id,
  };

  // $scope.addSponsor = () => {
  //   $("#add-sponsors").modal("show");
  // };

  // $scope.editSponsor = (object) => {
  //   $scope.selected_object = angular.copy(object);
  //   $("#edit-sponsors").modal("show");
  //   console.log($scope.selected_object);
  // };

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

  $scope.createSponsorshipsSponsor = $apiRequest.config(
    {
      method: "POST",
      url: "sponsors",
      data: $scope.sponsor,
    },
    function (response, data) {
      $("#add-sponsors").modal("hide");
      //TODO : refresh datatable
    }
  );

  // $scope.updateSponsorShipsSponsor = $apiRequest.config(
  //   {
  //     method: "PUT",
  //     url: "sponsors/" + $page.routeParams.id,
  //     data: $scope.selected_object,
  //   },
  //   function (response, data) {
  //      $("#edit-sponsors").modal("hide");
  //      //TODO : refresh datatable

  //   }

  // );

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

      $scope.calculatePercentageToComplete();
      $("#sponsor-modal").modal("hide");
    }
  );

  $scope.currentSponsorModalAction = "add";

  $scope.showSponsorModal = function (action, data = {}) {
    console.log({data})
    $scope.currentSponsorModalAction = action;
    if (action == "add") {
      $scope.createUpdateSponsorshipSponsor.config.method  = "POST";
    } else {
      $scope.createUpdateSponsorshipSponsor.config.method = action = "PUT";
      $scope.createUpdateSponsorshipSponsor.config.data = $scope.sponsor;
      $scope.sponsor = angular.copy(data);
    }
    $("#sponsor-modal").modal("show");
  };

  $scope.calculatePercentageToComplete = ()=>{
    let percentageToComplete = 0;
    $scope.sponsors.forEach(i => percentageToComplete += i.percentage);
    console.log({ percentageToComplete });
    $scope.object.percentage_to_complete = 100 - percentageToComplete;
  }
}
