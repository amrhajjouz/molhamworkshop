async function listCasesControllerInit($datalist) {
    return await $datalist('programs/medical/cases', true).load();
}

function listCasesController($scope, $init, $apiRequest, $page) {
    $scope.cases = $init;

    $scope.hideCaseRequest = (caseId) => {
        $apiRequest
            .config({ method: 'POST', url: `programs/medical/cases/${caseId}/hide`, data: { id: caseId } }, function (response, data) {
                $page.reload();
            }).send();
    };

    $scope.unhideCaseRequest = (caseId) => {
        $apiRequest
            .config({ method: 'POST', url: `programs/medical/cases/${caseId}/unhide`, data: { id: caseId } }, function (response, data) {
                $page.reload();
            }).send();
    };

    $scope.archiveCaseRequest = (caseId) => {
        $apiRequest
            .config({ method: 'POST', url: `programs/medical/cases/${caseId}/archive`, data: { id: caseId } }, function (response, data) {
                $page.reload();
            }).send();
    };

    $scope.unarchiveCaseRequest = (caseId) => {
        $apiRequest
            .config({ method: 'POST', url: `programs/medical/cases/${caseId}/unarchive`, data: { id: caseId } }, function (response, data) {
                $page.reload();
            }).send();
    };

    $scope.postCaseRequest = (caseId) => {
        $apiRequest
            .config({ method: 'POST', url: `programs/medical/cases/${caseId}/post`, data: { id: caseId } }, function (response, data) {
                $page.reload();
            }).send();
    };

    $scope.documentCaseRequest = (caseId) => {
        $apiRequest
            .config({ method: 'POST', url: `programs/medical/cases/${caseId}/document`, data: { id: caseId } }, function (response, data) {
                $page.reload();
            }).send();
    };

    $scope.undocumentCaseRequest = (caseId) => {
        $apiRequest
            .config({ method: 'POST', url: `programs/medical/cases/${caseId}/undocument`, data: { id: caseId } }, function (response, data) {
                $page.reload();
            }).send();
    };
   
    $scope.publishableCaseRequest = (caseId) => {
        $apiRequest
            .config({ method: 'POST', url: `programs/medical/cases/${caseId}/publishable`, data: { id: caseId } }, function (response, data) {
                $page.reload();
            }).send();
    };
}
