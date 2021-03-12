async function addStudentsControllerInit($apiRequest) {
    
    
    let countries =await  $apiRequest.config("countries").getData();

    let init = {
        countries: countries,
    };

    return init;
}


function addStudentsController($scope, $location, $apiRequest, $page, $init) {
    $scope.object = {
        semesters_count: 1,
        target: {
            required: 0,
        },
    };
    $scope.countries = $init.countries;
    $scope.statuses = [
        { id: "paused", name: "متوقفة" },
        { id: "not_funded", name: "غير مكتملة" },
        "not_funded",
        "currently_funded",
        "fully_funded",
    ];
    $scope.createStudent = $apiRequest.config(
        {
            method: "POST",
            url: "students",
            data: $scope.object,
        },
        function (response, data) {
            $page.navigate("students.overview", { id: data.id });
        }
    );
}