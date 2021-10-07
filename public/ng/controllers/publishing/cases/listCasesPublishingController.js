async function listCasesPublishingControllerInit($datalist) {
    return await $datalist('publishing/cases', true).load();
}

function listCasesPublishingController($scope, $init, $apiRequest, $page) {
    $scope.cases = $init;

    $scope.publishCaseRequest = (caseId) => {
        $apiRequest
            .config({ method: 'POST', url: `publishing/cases/${caseId}/publish`, data: { id: caseId } }, function (response, data) {
                $page.reload();
            }).send();
    };
  
    $scope.proofreadCaseRequest = (caseId) => {
        $apiRequest
            .config({ method: 'POST', url: `publishing/cases/${caseId}/proofread`, data: { id: caseId } }, function (response, data) {
                $page.reload();
            }).send();
    };

}
 