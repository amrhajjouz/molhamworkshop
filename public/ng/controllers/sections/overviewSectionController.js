function overviewSectionControllerInit ($apiRequest, $page) {
    return $apiRequest.config('sections/' + $page.routeParams.id).getData();
}
function overviewSectionController ($scope, $page, $apiRequest, $init) {
    $scope.section = $init;
}
