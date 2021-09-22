async function listCasesControllerInit($datalist) {
    return await $datalist('cases', true).load();
}

function listCasesController($scope, $init, $apiRequest, $page) {
    $scope.cases = $init;

    $scope.hideTargetRequest = (caseId) => {
        $apiRequest
            .config({ method: 'POST', url: `cases/${caseId}/hide`, data: { id: caseId } }, function (response, data) {
                $page.reload();
            }).send();
    };

    $scope.unHideTargetRequest = (caseId) => {
        $apiRequest
            .config({ method: 'POST', url: `cases/${caseId}/un_hide`, data: { id: caseId } }, function (response, data) {
                $page.reload();
            }).send();
    };

    $scope.archiveTargetRequest = (caseId) => {
        $apiRequest
            .config({ method: 'POST', url: `cases/${caseId}/archive`, data: { id: caseId } }, function (response, data) {
                $page.reload();
            }).send();
    };

    $scope.unArchiveTargetRequest = (caseId) => {
        $apiRequest
            .config({ method: 'POST', url: `cases/${caseId}/un_archive`, data: { id: caseId } }, function (response, data) {
                $page.reload();
            }).send();
    };

    $scope.postTargetRequest = (caseId) => {
        $apiRequest
            .config({ method: 'POST', url: `cases/${caseId}/post`, data: { id: caseId } }, function (response, data) {
                $page.reload();
            }).send();
    };

    $scope.documentTargetRequest = (caseId) => {
        $apiRequest
            .config({ method: 'POST', url: `cases/${caseId}/document`, data: { id: caseId } }, function (response, data) {
                $page.reload();
            }).send();
    };

    $scope.unDocumentTargetRequest = (caseId) => {
        $apiRequest
            .config({ method: 'POST', url: `cases/${caseId}/un_document`, data: { id: caseId } }, function (response, data) {
                $page.reload();
            }).send();
    };
}
