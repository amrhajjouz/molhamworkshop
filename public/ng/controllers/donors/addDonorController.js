function addDonorController ($scope, $apiRequest, $page) {
    $scope.donor = {};

    $scope.createDonor = $apiRequest.config({
        method: 'POST',
        url: 'donors',
        data: $scope.donor,
    }, function (response, data) {
        $page.navigate('donors.overview', {id: data.id});
    });
}
