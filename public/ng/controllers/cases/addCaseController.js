async function addCaseControllerInit($apiRequest) {
    
    let countries = await $apiRequest.config("countries").getData();
    let categories = await $apiRequest.config("categories?created_for=Cases").getData();
    let places = await $apiRequest.config("places").getData();


    let init = {
        countries: countries,
        categories: categories,
        places: places,
    };

    return init;
}

function addCaseController($scope, $location, $apiRequest, $page, $init) {
    $scope.statuses = [
        { id: "funded", name: "تم كفالتها" },
        { id: "unfunded", name: "غير مكفولة" },
        { id: "canceled", name: "ملغاة" },
        { id: "spent", name: "تم صرفها" },
    ];

    $scope.object = {
        target: {
            required: 0,
            visible: true,
            documented: false,
            archived: false,
            beneficiaries_count: 0,
            category_id: null,
        },
        place_id: null,
        status: "unfunded",
    };

    $scope.countries = $init.countries;
    $scope.categories = $init.categories;
    $scope.places = $init.places;



    $scope.createCase = $apiRequest.config(
        {
            method: "POST",
            url: "cases",
            data: $scope.object,
        },
        function (response, data) {
            $page.navigate("cases.overview", { id: data.id });
        }
    );
}