async function addPlacesControllerInit($apiRequest) {
    
    let countries =await  $apiRequest.config("countries").getData();
    let places =await  $apiRequest.config("places").getData();
    

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
            type: 'city',
            country_id:null
    };

    $scope.places = $init.places;
    $scope.countries = $init.countries;

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