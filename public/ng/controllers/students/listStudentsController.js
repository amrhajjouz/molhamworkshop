function listStudentsControllerInit($apiRequest) {
    return $apiRequest.config("students").getData();
}

function listStudentsController($scope, $init) {
    
    $scope.students = $init;
}