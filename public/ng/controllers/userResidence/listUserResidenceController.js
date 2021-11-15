function listUserResidenceControllerInit ($page, $datalist) {
    return $datalist('user_residences', true).load();
}

function listUserResidenceController ($scope, $init) {
   $scope.userResidences = $init;
}
