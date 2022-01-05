function listMembersLeaveControllerInit ($page, $datalist) {
    //console.log($datalist('members/leaves', true).load())
    return $datalist('members/leaves', true).load();
}

function listMembersLeaveController ($scope, $init) {
   $scope.leaves = $init;
}
