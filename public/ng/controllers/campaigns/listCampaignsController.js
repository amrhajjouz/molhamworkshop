function listCampaignsControllerInit($apiRequest) {
    return $apiRequest.config("campaigns").getData();
}

function listCampaignsController($scope, $init) {
    
    $scope.campaigns = $init;
}