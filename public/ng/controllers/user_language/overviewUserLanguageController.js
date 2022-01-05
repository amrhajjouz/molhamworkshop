function overviewUserLanguageControllerInit ($apiRequest, $page) {
    return $apiRequest.config('user_languages/' + $page.routeParams.id).getData();
}

function overviewUserLanguageController ($scope, $init) {
    $scope.userLanguage = $init;
}
