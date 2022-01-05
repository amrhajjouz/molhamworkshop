function userLanguagesControllerInit($apiRequest, $page, $datalist) {
    return $datalist('members/user_languages/' + $page.routeParams.id, true).load();
}

function userLanguagesController($scope, $apiRequest, $init) {
    $scope.userLanguages = $init;
}