async function addSponsorshipsControllerInit($apiRequest) {
    
    let countries =await  $apiRequest.config("countries").getData();
    let categories =await  $apiRequest.config("categories?created_for=Sponsorships").getData();
    let places = await $apiRequest.config("places").getData();


    let init = {
        countries: countries,
        categories: categories,
        places: places,
    };

    return init;
}


function addSponsorshipsController($scope, $location, $apiRequest, $page, $init) {
    $scope.object = {
        target: {
            required: 1,
            visible: true,
            documented: false,
            archived: false,
            beneficiaries_count: 1,
            category_id: null,
        },
        place_id: null,
    };
    $scope.countries = $init.countries;
    $scope.categories = $init.categories;
    $scope.places = $init.places;


    $scope.createSponsorShips = $apiRequest.config(
        {
            method: "POST",
            url: "sponsorships",
            data: $scope.object,
        },
        function (response, data) {
            $page.navigate("sponsorships.overview", { id: data.id });
        }
    );
}