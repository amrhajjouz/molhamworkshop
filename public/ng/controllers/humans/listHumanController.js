function listHumanControllerInit ($page, $datalist) {
    return $datalist('humans', true).load();
}

function listHumanController ($scope, $init) {
   $scope.humans = $init;
}
