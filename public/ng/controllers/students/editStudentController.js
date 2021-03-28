async function editStudentControllerInit($http, $page, $apiRequest) {

   return {
     object: await $apiRequest
       .config("students/" + $page.routeParams.id)
       .getData(),
     countries: await $apiRequest.config("countries").getData(),
     places: await $apiRequest.config("places").getData(),
   };
}



function editStudentController($scope, $page, $apiRequest, $init) {
    $scope.countries = $init.countries;
    $scope.places = $init.places;
    $scope.object = $init.object;

    if (!$scope.object.places) $scope.object.places = [];

    $scope.updateStudent = $apiRequest.config(
        {
            method: "PUT",
            url: "students",
            data: $scope.object,
        },
        function (response, data) {}
    );
}
