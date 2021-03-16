async function addStudentsControllerInit($apiRequest) {
    
    
    let countries =await  $apiRequest.config("countries").getData();
    let places = await $apiRequest.config("places").getData();

    let init = {
        countries: countries,
        places: places,
    };

    return init;
}


function addStudentsController($scope, $location, $apiRequest, $page, $init) {

    $scope.object = {
        semesters_count: 1,
        current_semester: 1,
        target: {
            required: 0,
            visible: true,
            documented: false,
            archived: false,
            beneficiaries_count: 1,
        },
        places: [],
    };

    $scope.countries = $init.countries;
    $scope.places = $init.places;

    $scope.semesters = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
    $scope.availableSemester = [1];
    
    $scope.handleChangeSemesterCount = () => {
        $scope.availableSemester =[]
        $scope.createStudent.errors.country_id = null;

        for (let index = 1; index <= $scope.object.semesters_count; index++){
            console.log(index);
            $scope.availableSemester.push(index);
        }
        $scope.$evalAsync();
    };
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