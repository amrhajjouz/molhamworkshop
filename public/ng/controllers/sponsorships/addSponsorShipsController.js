async function addSponsorShipsControllerInit($apiRequest) {
    
    let countries =await  $apiRequest.config("countries").getData();
    let categories =await  $apiRequest.config("categories?created_for=Sponsorships").getData();
    let places = await $apiRequest.config("places").getData();

    categories.push({
        id: null,
        name: "غير مصنفة",
    });

    let init = {
        countries: countries,
        categories: categories,
        places: places,
    };

    return init;
}


function addSponsorShipsController($scope, $location, $apiRequest, $page, $init) {
    $scope.object = {
        target: {
            required: 0,
            visible: true,
            documented: false,
            archived: false,
            beneficiaries_count: 0,
            category_id: null,
        },
        places:[]
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