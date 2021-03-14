async function addEventsControllerInit($apiRequest) {

    let init = {
    };

    return init;
}


function addEventsController($scope, $location, $apiRequest, $page, $init) {
    $scope.object = {
        public_visibility: false,
        verified: false,
        implemented: false,
        implementation_date: "",
        youtube_video_url: null,
        target: {
            required: 0,
            visible: true,
            documented: false,
            archived: false,
            beneficiaries_count: 0,
        },
    };


    $scope.createEvent = $apiRequest.config(
        {
            method: "POST",
            url: "events",
            data: $scope.object,
        },
        function (response, data) {
            $page.navigate("events.overview", { id: data.id });
        }
    );
}