function addUserContractControllerInit () {
    return [];
}

function addUserContractController ($scope, $apiRequest, $page) {

    $scope.userContract = {};

    $scope.createUserContract = $apiRequest.config({
        method: 'POST',
        url: 'user_contracts',
        data: $scope.userContract,
    }, function (response, data) {
        $page.navigate('user-contracts.overview', {id: data.id});
    });
}
