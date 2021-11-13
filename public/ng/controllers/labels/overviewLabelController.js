function overviewLabelControllerInit($apiRequest, $page) {
    return $apiRequest.config("labels/" + $page.routeParams.id).getData();
}

function overviewLabelController($scope, $init) {
    $scope.label = $init;
}
