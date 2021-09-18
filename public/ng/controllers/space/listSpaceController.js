function listSpaceControllerInit ($page, $datalist) {
    return $datalist('spaces', true).load();
}

function listSpaceController ($scope, $init) {
   $scope.spaces = $init;
}
