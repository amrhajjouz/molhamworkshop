function addLabelControllerInit () {
    return [];
}

function addLabelController ($scope, $apiRequest, $page) {

    $scope.label = {};

    $scope.createLabel = $apiRequest.config({
        method: 'POST',
        url: 'labels',
        data: $scope.label,
    }, function (response, data) {
        $page.navigate('labels.overview', {id: data.id});
    });
}
