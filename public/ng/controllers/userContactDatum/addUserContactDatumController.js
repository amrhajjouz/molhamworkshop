function addUserContactDatumControllerInit () {
    return [];
}

function addUserContactDatumController ($scope, $apiRequest, $page) {

    $scope.userContactDatum = {};

    $scope.createUserContactDatum = $apiRequest.config({
        method: 'POST',
        url: 'user_contact_data',
        data: $scope.userContactDatum,
    }, function (response, data) {
        $page.navigate('user-contact-data.overview', {id: data.id});
    });
}
