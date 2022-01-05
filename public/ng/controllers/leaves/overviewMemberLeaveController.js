function overviewMemberLeaveControllerInit ($apiRequest, $page) {
    return $apiRequest.config('members/leaves/' + $page.routeParams.id).getData();
}

function overviewMemberLeaveController ($scope, $init) {
    $scope.leave = $init;
}
