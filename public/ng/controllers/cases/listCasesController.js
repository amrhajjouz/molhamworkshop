async function listCasesControllerInit($datalist) {
  return await $datalist("cases", true).load();
}

function listCasesController($scope, $init) {
  $scope.cases = $init;
}
