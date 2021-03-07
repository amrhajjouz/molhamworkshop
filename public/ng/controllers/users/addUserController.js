function addUserController ($scope, $location, $apiRequest) {
    
    $scope.user = {};
    
    $scope.createUser = $apiRequest.config({
        method: 'POST',
        url: 'users',
        data: $scope.user,
    }, function (response, data) {
        alert(data.id);
    });
    
}