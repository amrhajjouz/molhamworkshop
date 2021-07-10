function listShortcutsControllerInit($datalist) {
  return $datalist("shortcuts", true).load();
}

function listShortcutsController($scope, $init) {
  $scope.shortcuts = $init;
}