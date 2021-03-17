async function addPlacesControllerInit($apiRequest) {
    let countries = await $apiRequest.config("countries").getData();
    let places = await $apiRequest.config("places").getData();

    let init = {
        countries: countries,
        places: places,
    };

    return init;
}

function addPlacesController($scope, $location, $apiRequest, $page, $init) {
    $scope.types = [
        { id: "province", name: "محافظة" },
        { id: "city", name: "مدينة" },
        { id: "district", name: "منطقة" },
        { id: "village", name: "قرية" },
    ];

    $scope.object = {
        name: null,
        parent_id: null,
        type: "province",
        country_id: null,
        parent_type: false,
    };

    $scope.places = $init.places;
    $scope.countries = $init.countries;
    $scope.parentPlaces = [];

    $scope.handleChangeParentType = async (type) => {

        $scope.parentPlaces = [];
        let url ;
        if(type && type == 'city'){
            url = `places/search?type=province`;
        }else{
            url = `places/search?type=${$scope.object.parent_type}`;

        }
        $scope.parentPlaces = await $apiRequest.config(url).getData();
        $scope.$evalAsync();

    };
   
    $scope.handleChangeType = async () => {

       $scope.createPlace.errors.type = null;
        if($scope.object.type == 'city') $scope.handleChangeParentType('city');
    };

    $scope.createPlace = $apiRequest.config(
        {
            method: "POST",
            url: "places",
            data: $scope.object,
        },
        function (response, data) {
            $page.navigate("places.overview", { id: data.id });
        }
    );
}
