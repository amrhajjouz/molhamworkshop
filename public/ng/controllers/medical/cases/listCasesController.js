async function listCasesControllerInit($datalist) {
    return await $datalist('programs/medical/cases', true).load();
}

function listCasesController($scope, $init, $apiRequest, $page) {
    $scope.cases = $init;

    $scope.hideCaseRequest = (caseId) => {
        if(!confirm('هل تريد التأكيد على إخفاء هذه الحالة ؟ ')) return;
        $apiRequest
            .config({ method: 'POST', url: `programs/medical/cases/${caseId}/hide`, data: { id: caseId } }, function (response, data) {
                $page.reload();
            }).send();
    };

    $scope.unhideCaseRequest = (caseId) => {
        if(!confirm('هل تريد التأكيد على إظهار هذه الحالة ؟ ')) return;
        $apiRequest
            .config({ method: 'POST', url: `programs/medical/cases/${caseId}/unhide`, data: { id: caseId } }, function (response, data) {
                $page.reload();
            }).send();
    };

    $scope.archiveCaseRequest = (caseId) => {
        if(!confirm('هل تريد التأكيد على أرشفة هذه الحالة ؟ ')) return;
        $apiRequest
            .config({ method: 'POST', url: `programs/medical/cases/${caseId}/archive`, data: { id: caseId } }, function (response, data) {
                $page.reload();
            }).send();
    };

    $scope.unarchiveCaseRequest = (caseId) => {
        if(!confirm('هل تريد التأكيد على إلغاء أرشفة هذه الحالة ؟ ')) return;
        $apiRequest
            .config({ method: 'POST', url: `programs/medical/cases/${caseId}/unarchive`, data: { id: caseId } }, function (response, data) {
                $page.reload();
            }).send();
    };

    $scope.documentCaseRequest = (caseId) => {
        if(!confirm('هل تريد التأكيد على توثيق هذه الحالة ؟ ')) return;
        $apiRequest
            .config({ method: 'POST', url: `programs/medical/cases/${caseId}/document`, data: { id: caseId } }, function (response, data) {
                $page.reload();
            }).send();
    };

    $scope.undocumentCaseRequest = (caseId) => {
        if(!confirm('هل تريد التأكيد على إلغاء توثيق هذه الحالة ؟ ')) return;
        $apiRequest
            .config({ method: 'POST', url: `programs/medical/cases/${caseId}/undocument`, data: { id: caseId } }, function (response, data) {
                $page.reload();
            }).send();
    };
   
    $scope.readyToPublishCaseRequest = (caseId) => {
        if(!confirm('هل تريد التأكيد على تعيين هذه الحالة جاهزة للنشر ؟ ')) return;
        $apiRequest
            .config({ method: 'POST', url: `programs/medical/cases/${caseId}/ready_to_publish`, data: { id: caseId } }, function (response, data) {
                $page.reload();
            }).send();
    };
}
