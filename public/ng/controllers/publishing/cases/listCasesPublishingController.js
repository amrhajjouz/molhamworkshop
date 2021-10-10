async function listCasesPublishingControllerInit($datalist) {
    return await $datalist('publishing/cases', true).load();
}

function listCasesPublishingController($scope, $init, $apiRequest, $page) 
{
    $scope.cases = $init;
    $scope.canProofread = (caseObject) => {
        let canProofread = true;
        if(caseObject.proofreadable['ar'] == false) canProofread = false;
        if(caseObject.title && caseObject.title.ar.proofread && caseObject.description && caseObject.description.ar.proofread && caseObject.details && caseObject.details.ar.proofread) {
            canProofread=false
        };

        return canProofread;
    }
    $scope.proofreadCaseRequest = (caseId) => {
        $apiRequest
            .config({ method: 'POST', url: `publishing/cases/${caseId}/proofread`, data: { id: caseId } }, function (response, data) {
                $page.reload();
            }).send();
    };

    $scope.publishCaseRequest = (caseId) => {
        $apiRequest
            .config({ method: 'POST', url: `publishing/cases/${caseId}/publish`, data: { id: caseId } }, function (response, data) {
                $page.reload();
            }).send();
    };
  
   

}
 