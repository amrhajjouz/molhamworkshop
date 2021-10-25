function editAgreementControllerInit ($page, $apiRequest) {
    return $apiRequest.config('agreements/' + $page.routeParams.id).getData();
}
function editAgreementController ($scope, $page, $apiRequest, $init,$filter) {
    $scope.agreement = $init;
    $scope.updateAgreement = $apiRequest.config({
        method : 'PUT',
        url : 'agreements/' + $page.routeParams.id,
        data : $scope.agreement,
    }, function (response, data) {

    });
}
