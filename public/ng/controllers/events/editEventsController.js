
async function editEventsControllerInit($http, $page, $apiRequest) {
    const object = await $apiRequest
        .config("events/" + $page.routeParams.id)
        .getData();
    const places = await $apiRequest.config("places").getData();

    if (object.implementation_date)
        object.implementation_date = new Date(object.implementation_date);

    object.date = object.date = new Date(
        object.date
    );

    
    const init = {
        object: object,
        places: places,
    };
    return init;
}

function editEventsController($scope, $page, $apiRequest, $init) {
    $scope.object = $init.object;
    $scope.places = $init.places;

    if (!$scope.object.places) $scope.object.places = [];


    // to reinitialize place errors
    $scope.$watchCollection(
        "object.places_ids",
        (oldData, newData) => {
            $scope.updateEvent.errors.places_ids = null;
        },
        true
    );

    $scope.$watchCollection(
        "object.donor_id",
        (oldData, newData) => {
            $scope.updateEvent.errors.donor_id = null;
        },
        true
    );

    $scope.updateEvent = $apiRequest.config(
        {
            method: "PUT",
            url: "events",
            data: $scope.object,
        },
        function (response, data) {}
    );
}
