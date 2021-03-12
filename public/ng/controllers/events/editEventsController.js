
async function editEventsControllerInit($http, $page, $apiRequest) {
    const object = await $apiRequest
        .config("events/" + $page.routeParams.id)
        .getData();

    if (object.implementation_date)
        object.implementation_date = new Date(object.implementation_date);

    object.date = object.date = new Date(
        object.date
    );
    const init = {
        object: object,
    };
    return init;
}

function editEventsController($scope, $page, $apiRequest, $init) {
    $scope.object = $init.object;

    $scope.updateEvent = $apiRequest.config(
        {
            method: "PUT",
            url: "events",
            data: $scope.object,
        },
        function (response, data) {}
    );
}
