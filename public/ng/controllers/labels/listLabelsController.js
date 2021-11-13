function listLabelsControllerInit($page, $datalist) {
    return $datalist("labels", true).load();
}

function listLabelsController($scope, $init) {
    $scope.labels = $init;
}
