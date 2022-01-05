function listUserLanguageControllerInit ($page, $datalist) {
    return $datalist('user_languages', true).load();
}

function listUserLanguageController ($scope, $init) {
   $scope.userLanguages = $init;
}
