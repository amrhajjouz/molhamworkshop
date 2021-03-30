function listStudentsControllerInit($datalist) {
  return $datalist("students", true).load();
}

function listStudentsController($scope, $init) {
    
    $scope.students = $init;
}