async function addPlaceControllerInit($apiRequest) {

  return {
    countries: await $apiRequest.config("countries").getData(),
    places: await $apiRequest.config("places").getData(),
  };
}

function addPlaceController($scope, $location, $apiRequest, $page, $init) {
  $scope.types = [{ id: "province", name: "محافظة" }, { id: "city", name: "مدينة" }, { id: "district", name: "منطقة" }, { id: "village", name: "قرية" },];
  $scope.place = { name: { ar: null, en: null }, parent_id: null, type: "province", country_code: null, parent_type: null, };
  $scope.places = $init.places;
  $scope.countries = $init.countries;
  $scope.parentPlaces = [];

  $scope.handleChangeParentType = async (type) => {
    $scope.parentPlaces = [];
    let url;
    if (type && type == "city") url = `places/search?type=province`;
    else url = `places/search?type=${$scope.place.parent_type}`;
    
    $scope.parentPlaces = await $apiRequest.config(url).getData();
    $scope.$evalAsync();
  };

  $scope.handleChangeType = async () => {
    $scope.createPlace.errors.type = null;
    if ($scope.place.type == "city") $scope.handleChangeParentType("city");
  };

  $scope.createPlace = $apiRequest.config({ method: "POST", url: "places", data: $scope.place }, function (response, data) { $page.navigate("places.overview", { id: data.id }); });
}