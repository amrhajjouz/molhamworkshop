function overViewUserSectionControllerInit ($apiRequest, $page) {
    return $apiRequest.config('user_sections/' + $page.routeParams.id).getData();
}

function overviewUserSectionController ($scope, $init) {
    $scope.userSection = $init;
}
