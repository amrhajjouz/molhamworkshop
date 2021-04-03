async function addEventControllerInit($apiRequest) {
  return {
    places: await $apiRequest.config("places").getData(),
  };
}

function addEventController($scope, $location, $apiRequest, $page, $init) {
  $scope.places = $init.places;

  $scope.object = {
    public_visibility: false,
    verified: false,
    implemented: false,
    implementation_date: "",
    youtube_video_url: null,
    target: {
      required: 1,
      visible: true,
      documented: false,
      archived: false,
      beneficiaries_count: 1,
    },
    places: [],
    admins_ids: [],
  };

  $scope.createEvent = $apiRequest.config(
    {
      method: "POST",
      url: "events",
      data: $scope.object,
    },
    function (response, data) {
      $page.navigate("events.overview", { id: data.id });
    }
  );
}
