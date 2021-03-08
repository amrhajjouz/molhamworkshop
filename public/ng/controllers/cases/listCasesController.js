function listCasesControllerInit($apiRequest) {
    return $apiRequest.config("cases").getData();
}

function listCasesController($scope, $init) {
    
    $scope.users = $init;
}