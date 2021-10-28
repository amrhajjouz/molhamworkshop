function editUserControllerInit ($http, $page, $apiRequest) {
    return $apiRequest.config('users/' + $page.routeParams.id).getData();
}

function editUserController ($scope, $page, $apiRequest, $init) {

    $scope.user = $init;

    $scope.offices = $apiRequest.config('offices').getData();

    $scope.updateUser = $apiRequest.config({
        method : 'PUT',
        url : 'users',
        data : $scope.user,
    }, function (response, data) {

    });

}
