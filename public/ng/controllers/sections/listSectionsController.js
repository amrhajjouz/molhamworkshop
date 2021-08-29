function listSectionsControllerInit($datalist, $location) {
    return $datalist('sections', true).load();
}

function listSectionsController($scope, $init, $datalist) {
    $scope.sections = $init;
}
