async function listCasesControllerInit($datalist) {
    return await $datalist('cases', true).load();
}

function listCasesController($scope, $init, $apiRequest, $page) {
    $scope.cases = $init;

    $scope.hideCaseRequest = (caseId) => {
        $apiRequest
            .config({ method: 'POST', url: `cases/${caseId}/hide`, data: { id: caseId } }, function (response, data) {
                $page.reload();
            }).send();
    };

    $scope.unhideCaseRequest = (caseId) => {
        $apiRequest
            .config({ method: 'POST', url: `cases/${caseId}/unhide`, data: { id: caseId } }, function (response, data) {
                $page.reload();
            }).send();
    };

    $scope.archiveCaseRequest = (caseId) => {
        $apiRequest
            .config({ method: 'POST', url: `cases/${caseId}/archive`, data: { id: caseId } }, function (response, data) {
                $page.reload();
            }).send();
    };

    $scope.unarchiveCaseRequest = (caseId) => {
        $apiRequest
            .config({ method: 'POST', url: `cases/${caseId}/unarchive`, data: { id: caseId } }, function (response, data) {
                $page.reload();
            }).send();
    };

    $scope.postCaseRequest = (caseId) => {
        $apiRequest
            .config({ method: 'POST', url: `cases/${caseId}/post`, data: { id: caseId } }, function (response, data) {
                $page.reload();
            }).send();
    };

    $scope.documentCaseRequest = (caseId) => {
        $apiRequest
            .config({ method: 'POST', url: `cases/${caseId}/document`, data: { id: caseId } }, function (response, data) {
                $page.reload();
            }).send();
    };

    $scope.undocumentCaseRequest = (caseId) => {
        $apiRequest
            .config({ method: 'POST', url: `cases/${caseId}/undocument`, data: { id: caseId } }, function (response, data) {
                $page.reload();
            }).send();
    };
}
