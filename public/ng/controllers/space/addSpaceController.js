function addSpaceControllerInit () {
    return [];
}

function addSpaceController ($scope, $apiRequest, $page) {

    $scope.space = {};

    $scope.createSpace = $apiRequest.config({
        method: 'POST',
        url: 'spaces',
        data: $scope.space,
    }, function (response, data) {
        $page.navigate('spaces.overview', {id: data.id});
    });
}
