function addUserController ($scope, $location, $apiRequest, $page) {

    $scope.user = {};

    $scope.offices = $apiRequest.config('offices').getData();

    $scope.createUser = $apiRequest.config({
        method: 'POST',
        url: 'users',
        data: $scope.user,
    }, function (response, data) {
        $page.navigate('users.overview', {id: data.id});
    });

}
