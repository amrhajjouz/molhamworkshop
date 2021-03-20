async function addEventsControllerInit($apiRequest) {

    const places = await $apiRequest.config("places").getData();

    let init = {
        places: places,
    };

    return init;
}

function addEventsController($scope, $location, $apiRequest, $page, $init) {

    $scope.places = $init.places;

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
        places:[] , 
    };

    // to reinitialize place errors
     $scope.$watchCollection(
         "object.places_ids",
         (oldData, newData) => {
             $scope.createEvent.errors.places_ids = null;
         },
         true
     );
     
     $scope.$watchCollection(
         "object.donor_id",
         (oldData, newData) => {
             $scope.createEvent.errors.donor_id = null;
         },
         true
     );

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
