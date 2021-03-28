async function editEventControllerInit($http, $page, $apiRequest) {
  const object = await $apiRequest
    .config("events/" + $page.routeParams.id)
    .getData();
  const places = await $apiRequest.config("places").getData();

  if (object.implementation_date)
    object.implementation_date = new Date(object.implementation_date);

  object.date = object.date = new Date(object.date);

  return {
    object: object,
    places: places,
  };
}

function editEventController($scope, $page, $apiRequest, $init) {
  $scope.object = $init.object;
  $scope.places = $init.places;

  if (!$scope.object.places) $scope.object.places = [];

  $scope.updateEvent = $apiRequest.config(
    {
      method: "PUT",
      url: "events",
      data: $scope.object,
    },
    function (response, data) {}
  );
}
