function listMembersLeavesControllerInit($datalist) {
    return $datalist("members/leaves", true).load();
}

function listMembersLeavesController($scope, $init) {
    $scope.leaves = $init;

}