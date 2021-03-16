function editDonorControllerInit ($page, $apiRequest) {
    return $apiRequest.config('donors/' + $page.routeParams.id).getData();
}
function editDonorController ($scope, $page, $apiRequest, $init) {
    $scope.donor = $init;
    $scope.updateDonor = $apiRequest.config({
        method : 'PUT',
        url : 'donors',
        data : $scope.donor,
    }, function (response, data) {

    });
}
