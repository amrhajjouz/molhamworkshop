function listFaqsControllerInit($datalist) {
  return $datalist("faqs", true).load();
}

function listFaqsController($scope, $init) {
  $scope.faqs = $init;
}