function addLeaveControllerInit () {
    return [];
}

function addLeaveController ($scope, $apiRequest, $page) {

    $scope.leave = {};

    $scope.createLeave = $apiRequest.config({
        method: 'POST',
        url: 'leaves',
        data: $scope.leave,
    }, function (response, data) {
        $page.navigate('leaves.overview', {id: data.id});
    });
}
