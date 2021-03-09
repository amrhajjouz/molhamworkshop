function listCampaignsControllerInit($apiRequest) {
    return $apiRequest.config("cases").getData();
}

function listCampaignsController($scope, $init) {
    
    $scope.users = $init;
}