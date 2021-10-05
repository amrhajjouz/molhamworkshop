async function listCasesPublishingControllerInit($datalist) {
    return await $datalist('publishing/cases', true).load();
}

function listCasesPublishingController($scope, $init, $apiRequest, $page) {
    $scope.cases = $init;

}
