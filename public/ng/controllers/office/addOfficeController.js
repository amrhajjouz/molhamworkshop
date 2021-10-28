function addOfficeController ($scope, $apiRequest, $page) {

    $scope.office = {};

    $scope.createOffice = $apiRequest.config({
        method: 'POST',
        url: 'offices',
        data: $scope.office,
    }, function (response, data) {
        $page.navigate('offices', {id: data.id});
    });
}
