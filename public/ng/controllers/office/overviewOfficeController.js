function overviewOfficeControllerInit ($apiRequest, $page) {
    return $apiRequest.config('offices/' + $page.routeParams.id).getData();
}

function overviewOfficeController ($scope, $init) {
    $scope.office = $init;
    console.log($init);
}
