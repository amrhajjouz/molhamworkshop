function overviewStudentControllerInit ($apiRequest, $page) {
    return $apiRequest.config('students/' + $page.routeParams.id).getData();
}

function overviewStudentController ($scope, $page, $apiRequest, $init) {
    $scope.object = $init;
    $scope.updateUser = $apiRequest.config({
        method : 'POST',
        url : 'students',
        data : $scope.object,
    }, function (response, data) {
        
    });    
    
}