async function listCasesTranslationControllerInit($datalist) {
    return await $datalist('translation/cases', true).load();
}

function listCasesTranslationController($scope, $init, $apiRequest, $page) {
    $scope.cases = $init;

}
