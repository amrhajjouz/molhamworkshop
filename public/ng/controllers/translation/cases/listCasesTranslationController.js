async function listCasesTranslationControllerInit($datalist) {
    return await $datalist('translation/cases', true).load();
}

function listCasesTranslationController($scope, $init, $apiRequest, $page) {
    $scope.cases = $init;
    $scope.canProofread = (caseObject) => {
        let canProofread = true;
        if(caseObject.proofreadable['en'] == false) canProofread = false;
        if(caseObject.title &&  caseObject.title.en &&  caseObject.title.en.proofread && caseObject.description && caseObject.description.en.proofread && caseObject.details && caseObject.details.en.proofread) {
            canProofread=false
        };

        return canProofread;
    }
    $scope.proofreadCaseRequest = (caseId) => {
        $apiRequest
            .config({ method: 'POST', url: `translation/cases/${caseId}/proofread`, data: { id: caseId } }, function (response, data) {
                $page.reload();
            }).send();
    };
    


}
