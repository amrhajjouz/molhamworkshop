function editSectionControllerInit ($page, $apiRequest) {
    return $apiRequest.config('sections/' + $page.routeParams.id).getData();
}
function editSectionController ($scope, $page, $apiRequest, $init) {
    $scope.section = $init;
    $scope.updateSection = $apiRequest.config({
        method : 'PUT',
        url : 'sections',
        data : $scope.section,
    }, function (response, data) {

    });
}
