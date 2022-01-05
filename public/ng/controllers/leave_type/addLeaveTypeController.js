function addLeaveTypeControllerInit () {
    return [];
}

function addLeaveTypeController ($scope, $apiRequest, $page) {

    $scope.leaveType = {};

    $scope.createLeaveType = $apiRequest.config({
        method: 'POST',
        url: 'leave_types',
        data: $scope.leaveType,
    }, function (response, data) {
        $page.navigate('leave_types.overview', {id: data.id});
    });
}
