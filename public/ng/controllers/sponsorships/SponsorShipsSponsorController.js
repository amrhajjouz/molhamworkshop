async function SponsorShipsSponsorControllerInit($http, $page, $apiRequest) {
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

function SponsorShipsSponsorController($scope, $page, $apiRequest, $init) {
  $scope.sponsors = $init.sponsors;
  $scope.object = $init.object;
  $scope.selected_object = {};

  // to reinitialize place errors
  $scope.$watchCollection(
    "object.donor_id",
    (newData, oldData) => {
      $scope.createSponsorShipsSponsor.errors.place_id = null;
    },
    true
  );

  $scope.sponsor = {
    donor_id: null,
    percentage: null,
    purpose_type: "\\App\\Models\\Sponsorship",
    purpose_id: $page.routeParams.id,
  };
  $scope.add_sponsor = () => {
    $("#add-sponsors").modal("show");
  };

  $scope.edit_sponsor = (object) => {
    $scope.selected_object = angular.copy(object)
    $("#edit-sponsors").modal("show");
    console.log($scope.selected_object);
  };

  $scope.get_max_percentage_on_update = () => {
    if (!$scope.selected_object) return 0;
    let sponsors = $scope.sponsors;
    sponsors = sponsors.filter(item => item.id != $scope.selected_object.id);

    let total = 0;

    sponsors.forEach(element => {
        total += element.percentage;
    });

    return 100- total;
  };

  $scope.createSponsorShipsSponsor = $apiRequest.config(
    {
      method: "POST",
      url: "sponsors",
      data: $scope.sponsor,
    },
    function (response, data) {
          $("#add-sponsors").modal("hide");

    }
  );

  $scope.updateSponsorShipsSponsor = $apiRequest.config(
    {
      method: "PUT",
      url: "sponsors/" + $page.routeParams.id,
      data: $scope.selected_object,
    },
    function (response, data) {
       $("#edit-sponsors").modal("hide");
       //TODO : refresh datatable

    }
  );
}
