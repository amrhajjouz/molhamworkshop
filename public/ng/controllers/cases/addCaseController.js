async function addCaseControllerInit($apiRequest) {
    
    let countries = await $apiRequest.config("countries").getData();
    let categories = await $apiRequest.config("categories?created_for=Cases").getData();
    let places = await $apiRequest.config("places").getData();

    categories.push({
        id:null , name:"غير مصنفة"
    })
    countries.push({ id: null, name: "يرجى اختيار دولة.." });

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
        places:[],
        status:'unfunded'
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