function addUserContractControllerInit ($apiRequest) {
    return [];
}

function addUserContractController ($scope, $apiRequest, $page) {
    $scope.userContract = {};
    $scope.createUserContract = $apiRequest.config({
        method: 'POST',
        url: 'user_contracts/'+ $scope.$routeParams.id,
        data:$scope.userContract,
    }, function (response, data) {
        $page.navigate('user_contracts.overview', {id: data.id , data : data});
    });
}
