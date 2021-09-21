async function listCasesControllerInit($datalist) {
    return await $datalist('cases', true).load();
}

function listCasesController($scope, $init, $apiRequest, $page) {
    $scope.cases = $init;

    $scope.hideTargetRequest = (targetId) => {
        $apiRequest
            .config({ method: 'POST', url: `targets/${targetId}/hide`, data: { id: targetId, targetable_type: 'cases', targetable_id: $page.routeParams.id } }, function (response, data) {
                $page.reload();
            }).send();
    };

    $scope.unHideTargetRequest = (targetId) => {
        $apiRequest
            .config({ method: 'POST', url: `targets/${targetId}/un_hide`, data: { id: targetId, targetable_type: 'cases', targetable_id: $page.routeParams.id } }, function (response, data) {
                $page.reload();
            }).send();
    };

    $scope.archiveTargetRequest = (targetId) => {
        $apiRequest
            .config({ method: 'POST', url: `targets/${targetId}/archive`, data: { id: targetId, targetable_type: 'cases', targetable_id: $page.routeParams.id } }, function (response, data) {
                $page.reload();
            }).send();
    };

    $scope.unArchiveTargetRequest = (targetId) => {
        $apiRequest
            .config({ method: 'POST', url: `targets/${targetId}/un_archive`, data: { id: targetId, targetable_type: 'cases', targetable_id: $page.routeParams.id } }, function (response, data) {
                $page.reload();
            }).send();
    };

    $scope.postTargetRequest = (targetId) => {
        $apiRequest
            .config({ method: 'POST', url: `targets/${targetId}/post`, data: { id: targetId, targetable_type: 'cases', targetable_id: $page.routeParams.id } }, function (response, data) {
                $page.reload();
            }).send();
    };

    $scope.documentTargetRequest = (targetId) => {
        $apiRequest
            .config({ method: 'POST', url: `targets/${targetId}/document`, data: { id: targetId, targetable_type: 'cases', targetable_id: $page.routeParams.id } }, function (response, data) {
                $page.reload();
            }).send();
    };

    $scope.unDocumentTargetRequest = (targetId) => {
        $apiRequest
            .config({ method: 'POST', url: `targets/${targetId}/un_document`, data: { id: targetId, targetable_type: 'cases', targetable_id: $page.routeParams.id } }, function (response, data) {
                $page.reload();
            }).send();
    };
}
