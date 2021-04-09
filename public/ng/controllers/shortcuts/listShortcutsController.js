function listShortcutsControllerInit($datalist) {
  return $datalist("faqs", true).load();
}

function listShortcutsController($scope, $init) {
  $scope.faqs = $init;
}