async function sponsorsStudentsControllerInit($http, $page, $apiRequest) {
  const sponsors = await $apiRequest
    .config("students/" + $page.routeParams.id + "/sponsors")
    .getData();

  const object = await $apiRequest
    .config("students/" + $page.routeParams.id)
    .getData();


  const init = {
    sponsors: sponsors,
    object: object,
  };
  return init;
}

function sponsorsStudentsController($scope, $page, $apiRequest, $init) {
  $scope.sponsors = $init.sponsors;
  $scope.object = $init.object;
  $scope.selected_object = {};


  $scope.sponsor = {
    donor_id: null,
    percentage: null,
    purpose_type: "\\App\\Models\\Student",
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

  $scope.createStudentsSponsor = $apiRequest.config(
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

  $scope.updateStudentsSponsor = $apiRequest.config(
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
