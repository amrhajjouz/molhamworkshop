function addUserSectionControllerInit () {
    return [];
}

function addUserSectionController ($scope, $apiRequest, $page) {

    $scope.userSection = {};

    $scope.createUserSection = $apiRequest.config({
        method: 'POST',
        url: 'user_sections',
        data: $scope.userSection,
    }, function (response, data) {
        $page.navigate('user_sections.overview', {id: data.id});
    });
}
