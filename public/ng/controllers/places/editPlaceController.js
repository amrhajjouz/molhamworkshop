async function editPlaceControllerInit($http, $page, $apiRequest) {
  const object = await $apiRequest
    .config("places/" + $page.routeParams.id)
    .getData();

  const countries = await $apiRequest.config("countries").getData();
  countries.forEach(c => c.name = JSON.parse(c.name));
  
  let url = "places/search";
  if (object.parent) {
    object.parent_type = object.parent.type;
    url += "?type=" + object.parent.type;
  }
  const parentPlaces = await $apiRequest.config(url).getData();

  return {
    object: object,
    countries: countries,
    parentPlaces: parentPlaces,
  };
}

function editPlaceController($scope, $page, $apiRequest, $init) {
  $scope.types = [
    { id: "province", name: "محافظة" },
    { id: "city", name: "مدينة" },
    { id: "district", name: "منطقة" },
    { id: "village", name: "قرية" },
  ];

  $scope.object = $init.object;

  $scope.countries = $init.countries;
  $scope.parentPlaces = $init.parentPlaces;

  $scope.handleChangeParentType = async (type) => {
    $scope.parentPlaces = [];
    let url;
    if (type && type == "city") {
      url = `places/search?type=province`;
    } else {
      url = `places/search?type=${$scope.object.parent_type}`;
    }
    $scope.parentPlaces = await $apiRequest.config(url).getData();
    $scope.$evalAsync();
  };

  $scope.handleChangeType = async () => {
    $scope.createPlace.errors.type = null;
    if ($scope.object.type == "city") $scope.handleChangeParentType("city");
  };

  $scope.updatePlace = $apiRequest.config(
    {
      method: "PUT",
      url: "places",
      data: $scope.object,
    },
    function (response, data) {}
  );
}