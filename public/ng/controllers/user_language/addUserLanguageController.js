function addUserLanguageControllerInit () {
    return [];
}

function addUserLanguageController ($scope, $apiRequest, $page) {

    $scope.userLanguage = {};

    $scope.createUserLanguage = $apiRequest.config({
        method: 'POST',
        url: 'user_languages',
        data: $scope.userLanguage,
    }, function (response, data) {
        $page.navigate('user_languages.overview', {id: data.id});
    });
}
