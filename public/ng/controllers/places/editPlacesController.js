// const { initial } = require("lodash");

async function editPlacesControllerInit($http, $page, $apiRequest) {
    const object = await $apiRequest
        .config("places/" + $page.routeParams.id)
        .getData();

    const countries = await $apiRequest.config("countries").getData();

    let url = "places/search";
    if (object.parent) {
        object.parent_type = object.parent.type
        url += "?type=" + object.parent.type;
    }
    const parentPlaces = await $apiRequest.config(url).getData();

    const init = {
        object: object,
        countries: countries,
        parentPlaces: parentPlaces,
    };
    return init;
}

function editPlacesController($scope, $page, $apiRequest, $init) {
    $scope.types = [
        { id: "province", name: "محافظة" },
        { id: "city", name: "مدينة" },
        { id: "district", name: "منطقة" },
        { id: "village", name: "قرية" },
    ];

    $scope.object = $init.object;

    $scope.countries = $init.countries;
    $scope.parentPlaces = $init.parentPlaces;

    //set parent type to object to check on input
    // if (object.parent) {
    //     switch (object.parent) {
    //         case value:
    //             break;

    //         default:
    //             break;
    //     }
    // }

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
